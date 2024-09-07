importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js');
   
	firebase.initializeApp({
        apiKey: "AIzaSyDOCQyOUapH4HxLKZZS6Mk2La2EURl22Ak",
        authDomain: "aypt-b20e4.firebaseapp.com",
        projectId: "aypt-b20e4",
        storageBucket: "aypt-b20e4.appspot.com",
        messagingSenderId: "19421078519",
        appId: "1:19421078519:web:4eb17253f6cac1bd3344f2"
    });

	const messaging = firebase.messaging();
	messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
        
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };
  
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});