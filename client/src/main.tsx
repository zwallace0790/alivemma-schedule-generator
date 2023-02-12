import React from 'react';
import { createRoot } from 'react-dom/client';
import { QueryClient, QueryClientProvider } from 'react-query'
import Application from './components/Application';
import './index.css';

const queryClient = new QueryClient();

createRoot(document.getElementById('app')).render(
    <QueryClientProvider client={queryClient}>
        <Application />
    </QueryClientProvider>
);
