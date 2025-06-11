function calculateTimeLeft(startTime, endTime = null) {
    const now = new Date().getTime();
    const eventTime = new Date(startTime).getTime();
    const eventEndTime = endTime ? new Date(endTime).getTime() : null;
    const difference = eventTime - now;

    // Check if event has ended
    if (eventEndTime && now > eventEndTime) {
        return "Event has ended";
    }

    // Check if event is in progress
    if (difference < 0) {
        if (!eventEndTime || now < eventEndTime) {
            return "Event in progress";
        }
        return "Event has ended";
    }

    // Calculate remaining time until start
    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
    const hours = Math.floor(
        (difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((difference % (1000 * 60)) / 1000);

    return `${days}d ${hours}h ${minutes}m ${seconds}s`;
}
