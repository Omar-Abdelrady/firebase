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
    apiKey: "AIzaSyBlIaGPWGr03yw2YuplgOpqzu3rgEtWDMc",
    authDomain: "notification-d6445.firebaseapp.com",
    projectId: "notification-d6445",
    storageBucket: "notification-d6445.appspot.com",
    messagingSenderId: "720935794921",
    appId: "1:720935794921:web:a80992da1e12de7eca5878",
    measurementId: "G-NCLTHYQKJW"
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
        icon: "./2048px-Instagram_icon.png",
        link: "http://127.0.0.1:8000/home/asd"
    };
    const webpush = {
        "fcm_options": {
            "link": "http://127.0.0.1:8000/home"
        }
    }

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
        webpush
    );
});
