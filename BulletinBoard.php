<?php
class BulletinBoard {
    private $messages = [];

    public function __construct($messages) {
        // 接收外部傳遞的公告訊息
        $this->messages = $messages;
    }

    public function display() {
        // 顯示公告內容
        echo '<div class="alert alert-info" role="alert">';
        echo '<h4 class="alert-heading">最新公告</h4>';
        echo '<ul>';
        foreach ($this->messages as $message) {
            echo '<li>' . htmlspecialchars($message) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}
?>
