<?php include '../resources/includes/init.php'; 

if (isset($_POST["submit"])) {

}

?>
<html>
	<?php include INCLUDES . '/head.php'; ?>
	<body>
		<div id="main">
			<?php include INCLUDES . '/header.php'; ?>
			<div id="content">
				<?php 

				echo exec("whoami");

				if (!empty($_POST)) {
					output($_POST);
					output($_FILES);
					if (isset($_FILES["item_photos"])) {
						move_uploaded_file($_FILES["item_photos"]["tmp_name"], RESOURCES . "/img/item/{$_FILES["item_photos"]["name"]}");
					}
				}
				?>
				<h2>Create a new Item</h2>
				<form name="new_item" action="new_item.php" method="post" enctype="multipart/form-data">
					<input type="text" name="item_artist" id="item_artist" placeholder="Artist" /><br />
					<select name="item_category">
						<?php 
						$stmt = $db->prepare("SELECT * FROM `category`");
						$stmt->execute();
						$result = $stmt->get_result();
						while ($cat = $result->fetch_assoc()) {
							echo "<option value=\"{$cat['id']}\">{$cat['name']}</option>";
						}
						?>
					</select><br />
					<ul id="item_photos_preview"></ul><br />
					<input type="file" accept="image/*" name="item_photos" id="item_photos" multiple/><br />
					<textarea rows="10" cols="50" placeholder="Description"></textarea><br />
					<input type="submit" name="submit" value="Create Item" />
				</form>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">

	$(function() {

		$("input#item_artist").autocomplete({
			source: "get_artists.php?artist_name=" + this.value,
			appendTo: "input#item_artist"
		});

		var photosInput = $("input[name='item_photos']");
		var photosPreview = $("ul#item_photos_preview");

		photosInput.change(function(event) {
			photosPreview.empty();
			var files = event.target.files;
			for (var i = 0, numFiles = files.length; i < numFiles; i++) {		
				photosPreview.append(
					$(document.createElement("li")).append(
						$(document.createElement("img"))
						.attr('src', URL.createObjectURL(files[i]))
						.attr('class', 'item_photo')
					)
				);

			}
		});
	});
</script>





