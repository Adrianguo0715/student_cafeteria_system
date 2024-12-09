<?php
class Gallery {
    private $images = [];

    public function __construct($imageFolderPath) {
        // 假設圖片存放在某個資料夾內，這裡會自動讀取所有圖片
        $this->images = glob($imageFolderPath . "/*.jpg"); // 只讀取 .jpg 格式的圖片
    }

    public function display() {
        // 若沒有圖片則不顯示
        if (empty($this->images)) {
            echo "<p>目前沒有圖片可顯示。</p>";
            return;
        }

        echo '<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">';
        echo '<div class="carousel-inner">';

        // 顯示圖片
        foreach ($this->images as $index => $image) {
            $active = $index === 0 ? 'active' : '';  // 使第一張圖片為活躍狀態
            echo '<div class="carousel-item ' . $active . '">';
            echo '<img src="' . htmlspecialchars($image) . '" class="d-block w-100" alt="Gallery Image">';
            echo '</div>';
        }

        echo '</div>';
        echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">';
        echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Previous</span>';
        echo '</button>';
        echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">';
        echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Next</span>';
        echo '</button>';
        echo '</div>';
    }
}
?>
