SELECT
  o.*,
  d.`product_sid`,
  d.`price`,
  d.`quantity`,
  p.`bookname`,
  p.`author`
FROM `orders` o
  JOIN `order_details` d
    ON o.sid=d.order_sid
  JOIN products p
    ON p.sid=d.product_sid
  WHERE o.member_sid=9;