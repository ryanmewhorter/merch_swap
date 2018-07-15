<?php include '../resources/includes/init.php'; 

?>
<html>
	<?php include INCLUDES . '/head.php'; ?>
	<body>
		<?php 
		include INCLUDES . '/nav.php'; 
		output($_FILES);
		output($_POST);
		if (isset($_FILES['item_photos'])) {
			$target_dir = RESOURCES . "/img/";
			$imgType = strtolower(pathinfo(basename($_FILES['item_photos']['name']), PATHINFO_EXTENSION));
			echo "Image type: {$imgType}";
		}
		?>
		<form name="new_item" action="new_item.php" method="post" enctype="multipart/form-data">
			<input type="text" name="item_name" placeholder="Name" /><br />
			<input type="text" name="item_artist" id="item_artist" placeholder="Artist" /><br />
			<select name="item_category">
				<option value="_new">New Category</option>
				<?php 
				$stmt = $db->prepare("SELECT * FROM `category`");
				$stmt->execute();
				$result = $stmt->get_result();
				while ($cat = $result->fetch_assoc()) {
					echo "<option value=\"{$cat['id']}\">{$cat['name']}</option>";
				}
				?>
			</select><br />
			<ul id="item_photos_display"></ul>
			<input type="file" accept="image/*" name="item_photos" id="item_photos" multiple/><br />
			<input type="submit" value="Create Item" />
		</form>
		<script type="text/javascript">
			$(document).ready(function() {
				$("input#item_artist").autocomplete({
					source: 'get_artists.php'
				});
			});
			//        $("input#item_photos").change(function() {
			//            var files = $(this).get(0).files;
			//            for (var i = 0, numFiles = files.length; i < numFiles; i++) {
			//            	  	var file = files[i];
			//            	  	console.log(file);
			//        			
			//            	  	var img = $("ul#item_photos_display").append(
			//                    $(document.createElement("li")).append(
			//                    		$(document.createElement("img")).attr('src', URL.createObjectURL(file))
			//                    )
			//                )
			//        			var ratio = Math.min(128 / img.attr('height'), 128 / img.attr('width'));
			//        			console.log(img);
			//				img.attr('height', ratio * $(this).attr('height'))
			//				img.attr('width', ratio * $(this).attr('width'))
			//            	}
			//        });
		</script>
	</body>
</html>