<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>iBank</title>
    <link rel="icon" type="image/png" sizes="16x16" href="Bank16x16.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="iBank.css">
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
        <?php
          if (isset($_GET['accNo'])) {
            if (is_numeric($_GET['accNo'])) {
              $accountNo = $_GET['accNo'];
              include('conn.php');
              $result = mysqli_query($conn, "SELECT * FROM bankcustomer WHERE accNo = $accountNo");
              if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
        ?>
        <table class="info">
          <caption>Account Details</caption>
          <tr>
            <td>
              <label>Account Number</label>
              <span><?php echo $row['accNo']; ?></span>
            </td>
            <td>
              <label>Account Holder Name</label>
              <span><?php echo $row['accHolder']; ?></span>
            </td>
          </tr>
          <tr>
            <td>
              <label>Account Type</label>
              <span><?php if ($row['accType'] == 0) { echo "<span>Saving Account</span>"; } else { echo "<span class='currentAcc'>Current Account</span>";} ?>
            </td>
            <td>
              <label>Email</label>
              <span><?php echo $row['email']; ?></span>
            </td>
          </tr>
          <tr>
            <td>
              <label>Current Balance</label>
              <span>
                <script type="text/javascript"> document.write(new Intl.NumberFormat('en-IN', { style: "currency", currency: "INR" }).format(<?php echo $row['curBal']; ?>));</script>
              </span>
            </td>
            <td>
              <label>Loan</label>
              <span>
                <script type="text/javascript"> document.write(new Intl.NumberFormat('en-IN', { style: "currency", currency: "INR" }).format(<?php echo $row['loan']; ?>));</script>
              </span>
            </td>
          </tr>
          <tr>
            <td colspan="2"> <a href="transaction.php?accNo=<?php echo $row['accNo']; ?>&action=transfer" class="link" title="Transfer amount from this account">Transfer Amount</a> </td>
          </tr>
        </table>
        <?php
              } else {
                echo '<div class="warning">Account not found..!</div>';
              }
            } else {
              echo '<div class="warning">Incorrect Account Number..!</div>';
            }
          }
         ?>
      </section>
      <hr>
      <footer>
        <p>&copy; 2021, i Bank. All rights reserved | Privacy Policy | Terms of Use | Investors</p>
      </footer>
    </center>
  </body>
</html>
