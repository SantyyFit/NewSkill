<?
session_start();
$sesion=$_SESSION['access'];
$usuario=$_GET["user"];													 
if ($sesion == md5($usuario))
{	
}
else{
	?>
	<SCRIPT LANGUAGE='JavaScript'>
	location.href='index.php';
	</script>
	<?
} ?>