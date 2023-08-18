/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');
   
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
        apiKey: "AIzaSyDKV6LBoajV3fSUeIe8J1xvS6Hc4LbVoX4",
        authDomain: "mikrotik-98046.firebaseapp.com",
        databaseURL: "https://mikrotik-98046-default-rtdb.asia-southeast1.firebasedatabase.app/",
        projectId: "mikrotik-98046",
        storageBucket: "mikrotik-98046.appspot.com",
        messagingSenderId: "585759188263",
        appId: "1:585759188263:web:4c5c465a40bd85b0c8f502",
        measurementId: "G-9KB6DRCFF5"
    });
  
/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
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
