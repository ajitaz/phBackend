<?php
require 'dbconn.php';
require 'header.php';

$option = $_GET['option'];

switch ($option) {

    case 'category':
        $sql = 'SELECT * FROM Category INNER JOIN Image ON Category.c_img_id=Image.img_id';
        break;

    case 'viewUser':
        $sql = 'SELECT * FROM User';
        break;

    case 'viewNursery':
        $sql = 'SELECT * FROM Nursery NATURAL JOIN Image';
        break;

    case 'viewProduct':
        $sql = 'SELECT pid, pname, p_description, price, quantity, iname, cname, cid, nid FROM Product NATURAL JOIN Image NATURAL JOIN Category';
        break;
    case 'viewArticle':
        $sql = 'SELECT aid, title, a_description, author_id, cid, iname, cname FROM Article NATURAL JOIN Image NATURAL JOIN Category';
        break;
    case 'nurseryViewProduct':
        $sql = 'SELECT pid, pname, p_description, price, quantity, iname, cname, cid, nid FROM Product NATURAL JOIN Image NATURAL JOIN Category NATURAL JOIN Nursery_Owner WHERE uid = ' . $_GET['uid'];
        break;
    case 'viewOrder':
        $sql = 'SELECT O.oid, I.iname, P.pname, P.price, O.quantity,O.date, username, U.phone, N.name, U.id, N.nur_email FROM Product_Order as O INNER JOIN Product as P ON O.pid = P.pid INNER JOIN Nursery as N ON N.nid = P.nid INNER JOIN Image as I ON P.img_id = I.img_id INNER JOIN User as U ON U.id = O.uid';
        break;
    case 'nurseryViewOrder':
        $sql = 'SELECT O.oid, I.iname, P.pname, P.price, O.quantity, username, U.phone, N.name FROM Product_Order as O INNER JOIN Product as P ON O.pid = P.pid INNER JOIN Nursery as N ON N.nid = P.nid INNER JOIN Image as I ON P.img_id = I.img_id INNER JOIN User as U ON U.id = O.uid WHERE O.nid = (SELECT nid FROM Nursery_Owner WHERE uid =' . $_GET['uid'] . ')';
        break;
    case 'viewNewArrival':
        $sql = 'SELECT nAid, pid, iname, cid FROM New_Arrival NATURAL JOIN Product INNER JOIN Image ON Product.img_id = Image.img_id';
        break;
    case 'emailUser':
        $sql = 'SELECT username, email FROM User WHERE id =' . $_GET['uid'];
        break;
    case 'nurseryViewArticle':
        $sql = 'SELECT aid, title, a_description, author_id, iname, cname FROM Article INNER JOIN Image ON Article.img_id = Image.img_id INNER JOIN Category ON Article.cid = Category.cid INNER JOIN Nursery_Owner ON Article.author_id = Nursery_Owner.uid WHERE Nursery_Owner.nid = (SELECT nid FROM Nursery_Owner WHERE uid =' . $_GET['uid'] . ')';
        break;
    case 'getCancleOrder':
        $sql = 'SELECT * FROM Cancel_Order';
        break;
}

$result = mysqli_query($conn, $sql);
$row = array();

while ($res = mysqli_fetch_assoc($result)) {
    $row[] = $res;
}

$result->free_result();

echo json_encode($row);

mysqli_close($conn);
