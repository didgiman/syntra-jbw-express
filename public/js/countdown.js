function calculateTimeLeft(startTime) {
            const now = new Date().getTime();
            const eventTime = new Date(startTime).getTime();
            const difference = eventTime - now;
            
            if (difference < 0) {
                return 'Event has started';
            }
            
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);
            
            return `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }
