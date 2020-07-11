<!DOCTYPE html>
<html>
<head><title>MyIP</title></head>
<body class="page_bg">
<p><?php echo date("Y-m-d H:i:s"); ?></p>
<p> <?php echo $_SERVER['REMOTE_ADDR']; ?> </p>
<p id="ip"></p>
<script>
	/**
	 * Get the user IP throught the webkitRTCPeerConnection
	 * @param onNewIP {Function} listener function to expose the IP locally
	 * @return undefined
	 */
	function getMyPrivateIP(onNewIP) { //  onNewIp - your listener function for new IPs
		console.log(onNewIP);
		//compatibility for firefox and chrome
		var myPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
		var pc = new myPeerConnection({
			iceServers: []
		}),
		noop = function() {},
		localIPs = {},
		ipRegex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/g,
		key;

		function iterateIP(ip) {
			console.log(ip);
			if (!localIPs[ip]) onNewIP(ip);
			localIPs[ip] = true;
		}

		 //create a bogus data channel
		pc.createDataChannel("");

		// create offer and set local description
		pc.createOffer(function(sdp) {
			console.log(sdp);
			sdp.sdp.split('\n').forEach(function(line) {
				if (line.indexOf('candidate') < 0) return;
				line.match(ipRegex).forEach(iterateIP);
			});
			
			pc.setLocalDescription(sdp, noop, noop);
		}, noop); 

		//listen for candidate events
		pc.onicecandidate = function(ice) {
			console.log(ice);
			if (!ice || !ice.candidate || !ice.candidate.candidate || !ice.candidate.candidate.match(ipRegex)) return;
			ice.candidate.candidate.match(ipRegex).forEach(iterateIP);
		};
	}

	getMyPrivateIP(function(ip){	document.getElementById("ip").innerHTML = ip;});

</script>


</body>
</html>