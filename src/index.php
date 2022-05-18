<!DOCTYPE html>
<html lang="en">
@@include('php/components/_head.php',{ "title":"OxyProject | Homepage" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content">
			@@include('php/layouts/_home-hero.php',{})
			@@include('php/layouts/_home-collections.php',{})
			@@include('php/layouts/_home-auctions.php',{})
		</main>
		@@include('php/components/_wavesBottom.php',{})
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_toTopButton.php',{})
	@@include('php/components/_scripts.php',{})
</body>

</html>