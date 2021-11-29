<?php
require(__DIR__ . "/../../../partials/nav.php");

$product = [];
if(isset($_GET["id"]))
{
	$id = se($_GET,"id", -1, false);
	if($id != -1)
	{
		$db = getDB();
		$product = "";
		$stmt = $db->prepare('SELECT * FROM Products WHERE id = :id');
		try{
			$stmt->execute([':id' => $id]);
			$product = $stmt->fetch(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			flash("Something went wrong...", "bg-red-200");
		}
		
	}

}
// id, user_id, name, description, stock, cost, image
?>



<div class="container mx-auto my-4 px-4">
<?php echo '<pre>' . var_export($product) . '</pre>';?>

</div>
