import "./bootstrap";
import "flowbite";
import startIdleWatcher from './idle';

// Start idle watcher after DOM is ready
document.addEventListener('DOMContentLoaded', function () {
	try {
		startIdleWatcher();
	} catch (e) {
		console.error('Failed to start idle watcher', e);
	}
});
