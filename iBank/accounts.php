<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>i Bank</title>
    <link rel="icon" type="image/png" sizes="16x16" href="Bank16x16.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="iBank.css">
    <style media="screen">
      tr:hover {
        background-color: white;
        color: white;
        border: 2px solid coral;
      }
      caption {
        color: royalblue;
        font: oblique 24px bolder Arial, sans-serif;
      }
    </style>
  </head>
  <body>
    <center>
      <section>
        <a href=""><h1><span>i </span>Bank &#x1f3e6;</h1></a>
        <div class="navBar">
          <a href="accounts.php" class="link">View Accounts</a>
          <a href="transaction.php" class="link">View Transactions</a>
          <a href="accounts.php" class="link">Transfer Money</a>
          <a href="" class="link">Register</a>
          <a href="" class="link">SignIn</a>
          <a href="index.php" class="link">Home</a>
          <a onclick="window.history.back();" class="btnBack" title="Back">&#x21A9;</a>
        </div>
        <hr class="makeSpace">
        <table border="1" class="fullSize">
          <caption>Customer Accounts</caption>
        <tr>
          <th>S. No.</th>
          <th>Account Number</th>
          <th>Account Holder Name</th>
          <th>Email</th>
          <th>Account Type</th>
          <th>Current Balance</th>
          <th>Loan</th>
          <th>Actions</th>
        </tr>
        <?php
          include('conn.php');
          $result = mysqli_query($conn, "SELECT * FROM bankcustomer");
          while($row = mysqli_fetch_array($result)) {
        ?>
        <tr onclick="location.href='accinformation.php?accNo=<?php echo $row['accNo']; ?>'">
          <td><?php echo $row['sno']; ?></td>
          <td><?php echo $row['accNo']; ?></td>
          <td><?php echo $row['accHolder']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <?php
            if ($row['accType'] == 0) {
              echo "<td>Saving Account</td>";
            } else {
              echo "<td class='currentAcc'>Current Account</td>";
            }
          ?>
          <td class="rightContent"><script type="text/javascript"> document.write(new Intl.NumberFormat('en-IN', { style: "currency", currency: "INR" }).format(<?php echo $row['curBal']; ?>));</script></td>
          <td class="rightContent"><script type="text/javascript"> document.write(new Intl.NumberFormat('en-IN', { style: "currency", currency: "INR" }).format(<?php echo $row['loan']; ?>));</script></td>
          <td class="actions">
            <a href="transaction.php?accNo=<?php echo $row['accNo'];?>&action=deposit" id="iDeposit">Deposit</a>
            <a href="transaction.php?accNo=<?php echo $row['accNo'];?>&action=debit" id="iDebit">Debit</a>
          </td>
        </tr>
        <?php } ?>
      </table>

    </section>
    <hr>
    <footer>
      <p>&copy; 2021, i Bank. All rights reserved | Privacy Policy | Terms of Use | Investors</p>
    </footer>
    </center>
  </body>
</html>
