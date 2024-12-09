### 初始化資料
#### 1. 店家表 (`store_list`)
INSERT INTO store_list (store_name, location, opening_hours) VALUES
('大學生牛肉麵', '一餐', '08:00-20:00'),
('燒肉飯專賣店', '三餐', '10:00-22:00'),
('韓式料理豆腐鍋', '教餐', '11:00-21:00');


#### **2. 品項表 (`menu_items`)**
INSERT INTO menu_items (item_name, category, price, store_id) VALUES
('牛肉麵', '麵', 120.00, 1),
('紅燒湯麵', '麵', 100.00, 1),
('燒肉飯', '飯', 85.00, 2),
('雞肉飯', '飯', 75.00, 2),
('豆腐鍋', '火鍋', 150.00, 3),
('泡菜鍋', '火鍋', 140.00, 3),
('炒飯', '飯', 90.00, 3),
('烤肉套餐', '其他', 160.00, 3);



#### 3. 員工表 (`staff`)
INSERT INTO staff (store_id, staff_name, department, grade) VALUES
(1, '林小芳', '客服部', '大二'),
(2, '張大海', '廚房部', '大四'),
(3, '李小明', '廚房部', '碩士'),
(3, '陳曉華', '化學系', '大四'),
(3, '林小蘭', '英文系', '大一');

#### 4. 店主表 (`owners`)
INSERT INTO owners (store_id, owner_name, owner_phone, owner_email) VALUES
(1, '王大山', '0912345678', 'owner1@example.com'),
(2, '陳小紅', '0987654321', 'owner2@example.com'),
(3, '李小綠', '0922333444', 'owner3@example.com');


#### 5. 顧客回饋表 (`feedback`)
INSERT INTO feedback (customer_name, store_id, item_id, feedback_content) VALUES
('王小明', 1, 1, '牛肉麵好吃，服務態度很好！'),
('李小華', 2, 3, '燒肉飯的份量有點少，希望改進。'),
('陳大衛', 3, 5, '環境乾淨，豆腐鍋很棒！'),
('張佳佳', 1, 2, '紅燒湯麵湯頭很濃郁！'),
('林安妮', 3, 7, '炒飯非常香，很推薦！');


#### 6. 訂單表 (`orders`)
INSERT INTO orders (store_id, staff_id, customer_name, total_amount) VALUES
(1, 1, '楊小姐', 240.00),
(2, 2, '吳先生', 160.00),
(3, 3, '何小姐', 300.00);
