-- 建立店家表 (store_list)
CREATE TABLE store_list (
    store_id INT AUTO_INCREMENT PRIMARY KEY,
    store_name VARCHAR(255) NOT NULL,
    location ENUM('一餐', '三餐', '教餐') NOT NULL,
    opening_hours VARCHAR(50) NOT NULL,
    UNIQUE (store_name, location) -- 確保相同名稱的店家不會重複出現在同一位置
);

-- 插入初始店家資料
INSERT INTO store_list (store_name, location, opening_hours) VALUES
('大學生牛肉麵', '一餐', '08:00-20:00'),
('燒肉飯專賣店', '三餐', '10:00-22:00'),
('韓式料理豆腐鍋', '教餐', '11:00-21:00');

-- 建立品項表 (menu_items)
CREATE TABLE menu_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    category ENUM('飯', '麵', '火鍋', '飲料', '素食', '其他') NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    store_id INT NOT NULL,
    UNIQUE (item_name, category, store_id), -- 確保同店家內的菜品唯一
    FOREIGN KEY (store_id) REFERENCES store_list(store_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- 插入初始品項資料
INSERT INTO menu_items (item_name, category, price, store_id) VALUES
('牛肉麵', '麵', 120.00, 1),
('紅燒湯麵', '麵', 100.00, 1),
('燒肉飯', '飯', 85.00, 2),
('雞肉飯', '飯', 75.00, 2),
('豆腐鍋', '火鍋', 150.00, 3),
('泡菜鍋', '火鍋', 140.00, 3),
('炒飯', '飯', 90.00, 3),
('烤肉套餐', '其他', 160.00, 3);

-- 建立員工表 (staff)
CREATE TABLE staff (
    staff_id INT AUTO_INCREMENT PRIMARY KEY,
    store_id INT NOT NULL,
    staff_name VARCHAR(255) NOT NULL,
    department VARCHAR(255) NOT NULL,
    grade ENUM('大一', '大二', '大三', '大四', '碩士', '博士') NOT NULL,
    UNIQUE (store_id, staff_name), -- 確保每家店不會有同名的員工
    FOREIGN KEY (store_id) REFERENCES store_list(store_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- 插入初始員工資料
INSERT INTO staff (store_id, staff_name, department, grade) VALUES
(1, '林小芳', '客服部', '大二'),
(2, '張大海', '廚房部', '大四'),
(3, '李小明', '廚房部', '碩士'),
(3, '陳曉華', '化學系', '大四'),
(3, '林小蘭', '英文系', '大一');

-- 建立店主表 (owners)
CREATE TABLE owners (
    owner_id INT AUTO_INCREMENT PRIMARY KEY,
    store_id INT NOT NULL,
    owner_name VARCHAR(255) NOT NULL,
    owner_phone VARCHAR(20) NOT NULL,
    owner_email VARCHAR(255) NOT NULL,
    UNIQUE (store_id), -- 確保每個店家只有一位店主
    UNIQUE (owner_phone), -- 確保電話號碼唯一
    UNIQUE (owner_email), -- 確保電子郵件唯一
    FOREIGN KEY (store_id) REFERENCES store_list(store_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- 插入初始店主資料
INSERT INTO owners (store_id, owner_name, owner_phone, owner_email) VALUES
(1, '王大山', '0912345678', 'owner1@example.com'),
(2, '陳小紅', '0987654321', 'owner2@example.com'),
(3, '李小綠', '0922333444', 'owner3@example.com');

-- 建立顧客回饋表 (feedback)
CREATE TABLE feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    store_id INT NOT NULL,
    item_id INT NOT NULL,
    feedback_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    feedback_content TEXT NOT NULL,
    UNIQUE (customer_name, store_id, item_id, feedback_time), -- 確保同一顧客對同一店家和品項的評論唯一
    FOREIGN KEY (store_id) REFERENCES store_list(store_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (item_id) REFERENCES menu_items(item_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- 插入初始顧客回饋資料
INSERT INTO feedback (customer_name, store_id, item_id, feedback_content) VALUES
('王小明', 1, 1, '牛肉麵好吃，服務態度很好！'),
('李小華', 2, 3, '燒肉飯的份量有點少，希望改進。'),
('陳大衛', 3, 5, '環境乾淨，豆腐鍋很棒！'),
('張佳佳', 1, 2, '紅燒湯麵湯頭很濃郁！'),
('林安妮', 3, 7, '炒飯非常香，很推薦！');

-- 建立訂單表 (orders)
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    store_id INT NOT NULL,
    staff_id INT,
    order_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    customer_name VARCHAR(255) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    UNIQUE (store_id, customer_name, order_time), -- 確保同店家同顧客不會在同一時間下兩單
    FOREIGN KEY (store_id) REFERENCES store_list(store_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- 插入初始訂單資料
INSERT INTO orders (store_id, staff_id, customer_name, total_amount) VALUES
(1, 1, '楊小姐', 240.00),
(2, 2, '吳先生', 160.00),
(3, 3, '何小姐', 300.00);

-- 建立使用者表 (users)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_role ENUM('store_owner', 'admin') NOT NULL,
    store_id INT NULL, -- 對應的店家ID，管理者為NULL
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (store_id) REFERENCES store_list(store_id) ON DELETE SET NULL -- 如果店家被刪除，對應的user store_id會變為NULL
);
