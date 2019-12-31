
importScripts('https://www.gstatic.com/firebasejs/7.5.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.5.0/firebase-messaging.js');

// Your web app's Firebase configuration
var firebaseConfig = {
      apiKey: "AIzaSyCHjUBC1wzeGqPXpuNpsFHa3jJK10EgXlw",
      authDomain: "test-project-220bb.firebaseapp.com",
      databaseURL: "https://test-project-220bb.firebaseio.com",
      projectId: "test-project-220bb",
      storageBucket: "test-project-220bb.appspot.com",
      messagingSenderId: "428037360287",
      appId: "1:428037360287:web:054e8d96ccb28dac5b70aa"
  };
  // Initialize Firebase

  firebase.initializeApp(firebaseConfig);

  const messaging = firebase.messaging();

//
// messaging.setBackgroundMessageHandler(function (payload) {
//     console.log('[firebase-messaging-sw.js] Received background message ', payload);
//     /*return self.registration.showNotification(notificationTitle,
//    notificationOptions);*/
// });



