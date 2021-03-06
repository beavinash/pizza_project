<?php include '../../view/header.php'; ?>
<main>
    <section>
        <h1>Today is day <?php echo $current_day; ?></h1>
        <form action="index.php" method="post">
            <input type="hidden" name="action" value="next_day">
            <input type="submit" value="Advance to day <?php echo $current_day + 1; ?>" />
        </form>

        <form  action="index.php" method="post">
            <input type="hidden" name="action" value="initial_db">           
            <input type="submit" value="Initialize DB (making day = 1)" />
            <br>
        </form>
        <br>
        <h2>Today's Orders</h2>
        <?php if (count($todays_orders) > 0): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Room No</th>
                    <th>Status</th>
                </tr>

                <?php foreach ($todays_orders as $todays_order) : ?>
                    <tr>
                        <td><?php echo $todays_order['id']; ?> </td>
                        <td><?php echo $todays_order['room_number']; ?> </td>  
                        <td><?php echo $todays_order['status']; ?> </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No Orders Today </p>
        <?php endif; ?>

        <!-- PROJECT 2 -->
        <h2>Undelivered Supply Orders</h2>
        <?php if (count($undelivered_orders) > 0): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Flour</th>
                    <th>Cheese</th>
                </tr>

                <?php foreach ($undelivered_orders as $undelivered_orders) : ?>
                    <tr>
                        <td><?php echo $undelivered_orders['orderid']; ?> </td>
                        <td><?php echo $undelivered_orders['flour_qty']; ?> </td>  
                        <td><?php echo $undelivered_orders['cheese_qty']; ?> </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No undelivered supply orders</p>
        <?php endif; ?>

        <h2>Current Inventory</h2>
        <table>
            <tr>
                <th>flour</th>
                <th>cheese</th>
            </tr>

            <tr>
                <td><?php echo $inventory['flour']; ?> </td>
                <td><?php echo $inventory['cheese']; ?> </td>  
            </tr>
        </table>
    </section>

</main>
<?php include '../../view/footer.php'; ?>