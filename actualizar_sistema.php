<?php
function full_copy($source, $target)
{
    if (is_dir($source)) {
        @mkdir($target);
        $d = dir($source);
        while (FALSE !== ($entry = $d->read())) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            $Entry = $source . '/' . $entry;
            if (is_dir($Entry)) {
                full_copy($Entry, $target . '/' . $entry);
                continue;
            }
            copy($Entry, $target . '/' . $entry);
        }
        $d->close();
    } else {
        copy($source, $target);
    }
}
$source = '/home/imporsuit/public_html/repositorio';
$destination = '.';
full_copy($source, $destination);
echo "Página actualizada";
?>
<script>
    setTimeout(() => {
        window.open('db_update.php');
    }, 2000);
</script>