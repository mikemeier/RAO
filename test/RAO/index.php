<?php

	session_start();
	$loggedin = $_SESSION['loggedin'] = (bool)@$_GET['loggedin'];

	/**
	 * Charset setzen
	 */
	header('Content-Type: text/html; charset=utf-8');

	/**
	 * Bootstrap ausführen
	 */
	require_once '../../application/Bootstrap.php';
	
	/**
	 * ObjectTypes laden
	 */
	require_once 'createObjectTypes.php';
	
	/**
	 * Bild einlesen für MetaDaten
	 */
	use PHPWiki\RAO\ReadAccessObject;
	$image	= new ReadAccessObject(@$_GET['id'], $imageObjectType);
	$meta	= $image->getMetaData();
	
?>

Bild mit der ID <?php echo @$_GET['id']; ?><br />

<?php if($image->hasAccess()){ ?>
	<a href="get_image.php?id=<?php echo @$_GET['id'].'&loggedin='. $loggedin; ?>">
		<img 
			alt="<?php echo $meta['name']; ?>" 
			src="get_image.php?id=<?php echo @$_GET['id'].'&loggedin='. $loggedin; ?>" 
		/>
	</a>
<?php }else { ?>
	Keinen Zugriff auf diese Datei!
<?php } ?>

<br />
<br />

<a href="get_text.php?id=<?php echo @$_GET['id']; ?>">
	Text mit der ID <?php echo @$_GET['id']; ?>
</a>