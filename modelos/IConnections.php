<?php
interface IConnections
{
	function fetch();
	function insert($prepareStatement,$arrayString);
}
?>