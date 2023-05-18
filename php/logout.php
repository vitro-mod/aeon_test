<?php
if (!empty($_GET['session'])) {
    session_name($_GET['session']);
}
session_start();
session_destroy();