<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error text-center" onclick="this.classList.add('hidden');"><?= $message ?></div>
