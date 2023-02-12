import React from 'react';
import { useQuery } from 'react-query';

interface ScheduleEvent {
  name: string;
  coach: string;
  start: string;
  end: string;
}

const Application: React.FC = () => {
  const { isLoading, error, data } = useQuery('schedule', () =>
    fetch('/api/schedule.php').then(res =>
      res.json()
    )
  );

  if (isLoading) return <span>Loading...</span>;

  if (error) return <span>An error has occurred: {(error as Error).message}</span>;

  return (
    <div className="grid-cols-8">
      {Object.entries(data).map(([day, events]: any) => (
        <div className="grid grid-cols-1">
          <div className="col-span-1">
            <h2>{day}</h2>
            {events.map((event: ScheduleEvent) => (
              <div className="col-span-1">
                <h3>{event.name}</h3>
                <p>{event.coach}</p>
                <p>{event.start} - {event.end}</p>
              </div>
            ))
            }
          </div>
        </div>
      ))}
    </div>
  );
};

export default Application;
