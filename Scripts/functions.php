<?php
    
    //filter Inputs Value function.
    function cleanUpInputs($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //redirect func
    function redirect($url)
    {
        if (!headers_sent())
        {
            header("Location: $url");
        }
        else
        {
            echo "<script type='text/javascript'>window.location.href='$url'</script>";
            echo "<noscript><meta http-equiv='refresh' content='0;url=$url'/></noscript>";
        }

        exit;
    }
?>