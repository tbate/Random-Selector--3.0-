<div id="footer">
            Copyright <?php echo date("Y"); ?>, Random Selector
        </div>
    </body>
</html>
<?php 
    if(isset($connection))
    {
        mysqli_close($connection);
    }
?>