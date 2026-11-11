importScripts(
  "https://www.gstatic.com/firebasejs/11.10.0/firebase-app-compat.js",
);
importScripts(
  "https://www.gstatic.com/firebasejs/11.10.0/firebase-messaging-compat.js",
);

firebase.initializeApp({
  apiKey: "AIzaSyBDKZm1RoRkhXuWysLYL59c-wFl6F-zOlY",
  authDomain: "facalty-8f3a6.firebaseapp.com",
  projectId: "facalty-8f3a6",
  storageBucket: "facalty-8f3a6.firebasestorage.app",
  messagingSenderId: "466150173990",
  appId: "1:466150173990:web:d3f75a89fb9975bb90e5e7",
  measurementId: "G-ZRG1ZY5KMV",
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
  const title = payload.notification?.title || payload.data?.title || "Faculty Finder";
  const options = {
    body: payload.notification?.body || payload.data?.body || "",
    icon: "/assets/newlogo.png?v=20260825",
    data: payload.data || {},
  };
  self.registration.showNotification(title, options);
});

self.addEventListener("notificationclick", (event) => {
  event.notification.close();
  const linkUrl = event.notification?.data?.linkUrl;
  if (linkUrl) {
    event.waitUntil(clients.openWindow(linkUrl));
  }
});
