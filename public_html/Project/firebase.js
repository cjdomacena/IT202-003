const firebaseConfig = {

	apiKey: "AIzaSyAtDRVpNC08sBmFglKdLc_A0jKZQamhcGw",

	authDomain: "it202-30226.firebaseapp.com",

	projectId: "it202-30226",

	storageBucket: "it202-30226.appspot.com",

	messagingSenderId: "731886118464",

	appId: "1:731886118464:web:34bcffa44833faaa4461a5"

};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
// Get a reference to the storage service, which is used to create references in your storage bucket
var storage = firebase.storage();