<?php
require_once(__DIR__ . "../../../../partials/nav.php");
// session_start();
// if (is_logged_in()) {
// 	if (isset($_GET["filter"])) {
// 		$db = getDB();
// 		$col = se($_GET, 'filter', "all_products", false);
// 		$user_id = get_user_id();
// 		if ($col == 'filter_by_price_asc') {
// 			$stmt = $db->prepare("SELECT * FROM Products WHERE (user_id = :uid) ORDER BY cost ASC  LIMIT 10");
// 		} else if ($col == 'filter_by_price_desc') {
// 			$stmt = $db->prepare("SELECT * FROM Products WHERE (user_id = :uid) ORDER BY cost DESC  LIMIT 10");
// 		} else if ($col == 'filter_by_name') {
// 			$stmt = $db->prepare("SELECT * FROM Products WHERE (user_id = :uid) ORDER BY name ASC  LIMIT 10");
// 		} else {
// 			$stmt = $db->prepare("SELECT * FROM Products WHERE (user_id = :uid) ORDER BY name ASC LIMIT 10");
// 		}

// 		try {
// 			$stmt->execute([":uid" => $user_id]);
// 			$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// 		} catch (PDOException $e) {
// 			flash("Something Went Wrong...", "bg-red-200");
// 		}
// 	}
// } else {
// 	die(header("Location: " . get_url("index.php")));
// }
// 
?>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-app.js"></script>
<!-- Include the storage api -->
<script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-storage.js"></script>

<script>
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

	function get(event) {

		let files = event.target.fileToUpload.files;
		if (files.length > 0) {
			let file = files[0];
			console.log(file);
			storage.ref().child("images/" + file.name).put(file).then(res => {
				console.log(res);
				res.ref.getDownloadURL().then((downloadURL) => {
					//this is the url you'd save in the database
					document.getElementById("dest").src = downloadURL;
				});
				//alert(JSON.stringify(res));
			}).catch(err => {
				console.log(err);
				//alert(JSON.stringify(err));
			})
		}
	}
</script>
