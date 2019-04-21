<?php
// запрещаем вывод предупреждений
Error_Reporting(E_ALL & ~E_NOTICE);

// подключаем файл, который устанавливает соединение с базой данных
include('config.inc.php');

// Устанавливаем количество записей, которые будут выводиться на одной странице
// Поставьте нужное вам число. Для примера я указал одну запись на страницу
$quantity=5;
// Ограничиваем количество ссылок, которые будут выводиться перед и
// после текущей страницы
$limit=3;

// Если значение page= не является числом, то показываем
// пользователю первую страницу
if(!is_numeric($page)) $page=1;

// Если пользователь вручную поменяет в адресной строке значение page= на нуль,
// то мы определим это и поменяем на единицу, то-есть отправим на первую
// страницу, чтобы избежать ошибки
if ($page<1) $page=1;


// Узнаем количество всех доступных записей 
$result2 = mysql_query("SELECT * FROM `a68000_book`.`phones`;");
$num = mysql_num_rows($result2);

// Вычисляем количество страниц, чтобы знать сколько ссылок выводить
$pages = $num/$quantity;

// Округляем полученное число страниц в большую сторону
$pages = ceil($pages);

// Здесь мы увеличиваем число страниц на единицу чтобы начальное значение было
// равно единице, а не нулю. Значение page= будет
// совпадать с цифрой в ссылке, которую будут видеть посетители
$pages++; 

// Если значение page= больше числа страниц, то выводим первую страницу
if ($page>$pages) $page = 1;







//Телефоны
if($_GET['page']=='phones'){
 
  
  if($_GET['status']=='1') {$sql = "SELECT *  FROM `a68000_book`.`phones`  WHERE status = '1' ORDER BY id DESC LIMIT 10 ";  echo "<h3>Заказанные телефоны</h3>";}
                            else if($_GET['status']=='2') {$sql = "SELECT *  FROM `a68000_book`.`phones` WHERE status = '2' ORDER BY id DESC LIMIT 10 "; echo "<h3>Прибывшие телефоны</h3>";}
                                                           else   if($_GET['status']=='3') {$sql = "SELECT *  FROM `a68000_book`.`phones` WHERE status = '3' ORDER BY id DESC LIMIT 10 "; echo "<h3>Готовые телефоны</h3>";}
                                                                                            else   if($_GET['status']=='4') {$sql = "SELECT *  FROM `a68000_book`.`phones` WHERE status = '4' ORDER BY id DESC LIMIT 10 "; echo "<h3>Проданные телефоны</h3>";}
                                                                                                                             else   if($_GET['status']=='5') {$sql = "SELECT *  FROM `a68000_book`.`phones` WHERE status = '5' ORDER BY id DESC LIMIT 10 "; echo "<h3>Неисправные телефоны</h3>";}
                                                                                                                                         else   if($_GET['status']=='6') {$sql = "SELECT *  FROM `a68000_book`.`phones` WHERE status = '6' ORDER BY id DESC LIMIT 10 "; echo "<h3>Списанные телефоны</h3>";}
                                                                                                                                                              else {$sql = "SELECT *  FROM `a68000_book`.`phones` Where status <> 6 ORDER BY id DESC LIMIT 10 "; echo "<h3>Все телефоны</h3>";}
  
  $result = mysql_query($sql);

    echo "<table width='100%' class='accruals'>";
    echo "<tr style='background-color: #f6f8f9;border-top: 1px solid #cfd8dc;border-bottom: 1px solid #eceff1;'><td style='padding: 10px;font-weight: bold; color: #667e8c;'>Номер</td><td  style='padding: 10px;font-weight: bold; color: #667e8c;'>Название</td><td  style='padding: 10px;font-weight: bold; color: #667e8c;'>Трэк номер</td><td  style='padding: 10px;font-weight: bold; color: #667e8c;'>Цена</td><td  style='padding: 10px;font-weight: bold; color: #667e8c;'>Статус</td><td  style='padding: 10px;font-weight: bold; color: #667e8c;'>Дата заказа</td></tr>";
  // Выводим заголовок с номером текущей страницы 
echo '<strong style="color: #df0000">Страница № ' . $page . 
'</strong><br /><br />'; 
  
  // Переменная $list указывает с какой записи начинать выводить данные.
// Если это число не определено, то будем выводить
// с самого начала, то-есть с нулевой записи
if (!isset($list)) $list=0;

// Чтобы у нас значение page= в адресе ссылки совпадало с номером
// страницы мы будем его увеличивать на единицу при выводе ссылок, а
// здесь наоборот уменьшаем чтобы ничего не нарушить.
$list=--$page*$quantity;

  
  // Делаем запрос подставляя значения переменных $quantity и $list
$result = mysql_query("SELECT * FROM `a68000_book`.`phones`  LIMIT $quantity OFFSET $list;");

// Считаем количество полученных записей
$num_result = mysql_num_rows($result);

// Выводим все записи текущей страницы
for ($i = 0; $i<$num_result; $i++) {
    $row = mysql_fetch_array($result);
    echo '<div><strong>' . $row["id"] . '</strong><br />' . 
    $row["description"] . '</div><br>';
}
  
  
  
  while ($row=mysql_fetch_array($result)){
        $id  = $row['id'];
        $name  = $row['name'];
        $track  = $row['track'];
         $price = $row['price_buy']+$row['price_delivery'];
        $status = $row['status'];
        $date_order  = $row['date_order'];
         if($status=='1') $status ='Заказан'; else  if($status=='2') $status ='Прибыл';else  if($status=='3') $status ='Готов'; else  if($status=='4') $status ='Продан'; else  if($status=='5') $status ='Неисправен'; else  if($status=='6') $status ='Списан';
      echo "<tr class='tr_bg_color'><td>".$id."</td><td title=' ".$name."'><a href='?phone=$id'>".$name."</a></td><td>".$track."</td><td style='color: #a52a2a;'>".$price."$</td><td>".$status."</td><td>".$date_order."</td></tr>";

    } echo "</table>";
}//Телефоны
?>