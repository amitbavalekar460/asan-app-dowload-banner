if (!window.location.hostname.includes("localhost")) {
3	    var xhr = new XMLHttpRequest();
4	    xhr.open("POST", "https://simple-banner.glitch.me/hostname", true);
5	    xhr.setRequestHeader('Content-Type', 'application/json');
6	    xhr.send(JSON.stringify({ hostname: window.location.hostname }));
7	}