<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Transaction</title>
    <link rel="icon" type="image/png" sizes="16x16" href="Bank16x16.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="iBank.css">
    <style media="screen">
      .deposit {
        color: #080;
      }
      .debit {
        color: #e00;
      }
      .trans {
        background-color: #f3e5ab;
        width: 30em;
      }
      .trans caption {
        background-color: #93c572;
      }
      .trans td {
        padding: 12px 20px;
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
        <?php
          include('conn.php');
          date_default_timezone_set("Asia/Kolkata");
          $timestamp = date("d-m-Y h:i:s a");
          if (isset($_GET['accNo'])) {
            if (is_numeric($_GET['accNo'])) {
              $accountNo = $_GET['accNo'];
              if (isset($_GET['action'])) {
                if (ctype_alpha($_GET['action'])) {
                  $action = $_GET['action'];
                  if ($action == 'transfer') {
                    $result = mysqli_query($conn, "SELECT * FROM bankcustomer WHERE accNo = $accountNo");
                    if (mysqli_num_rows($result) > 0) {
                      $row = mysqli_fetch_array($result);
                    ?>
                    <form class="" action="" method="post">
                    <table class="info trans">
                      <caption>Transfer</caption>
                      <tr>
                        <td style="text-align: left;">From</td>
                      </tr>
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
                        <td style="text-align: left;">To</td>
                      </tr>
                      <tr>
                        <td>
                          <label>Account Number</label>
                          <span>
                            <select id="accNos" name="accNoTo" onchange="showName(this);" required>
                              <option value="">Select Account</option>
                              <?php $result = mysqli_query($conn, "SELECT * FROM bankcustomer WHERE accNo != $accountNo");
                                while($row = mysqli_fetch_array($result)) { ?>
                              <option value="<?php echo $row['accNo']; ?>"><?php echo $row['accNo']; ?></option>
                              <?php } ?>
                            </select>
                          </span>
                        </td>
                        <td>
                          <label>Account Holder Name</label>
                          <span>
                            <select id="accHos" name="" disabled>
                              <option value="">--Name--</option>
                              <?php mysqli_data_seek($result, 0);  while($row = mysqli_fetch_array($result)) { ?>
                              <option value=""><?php echo $row['accHolder']; ?></option>
                              <?php } ?>
                            </select>
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td style="text-align: left;">Amount</td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <input type="number" name="amount" value="0" min="100" class="fontt" max="10000000">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <input type="submit" name="transfer" value="Confirm" title="Confirm" class="fontt btnBack">
                          <a onclick="window.history.back();" class="fontt btnBack" title="Cancel">Cancel</a>
                        </td>
                      </tr>
                    </table>
                    </form>
                    <?php
                      if (isset($_POST['transfer'])) {
                        if (is_numeric($_POST['amount'])) {
                          $debitAmount = $_POST['amount'];
                          $accNoTo = $_POST['accNoTo'];
                          $accNoFrom = $_GET['accNo'];
                          $result = mysqli_query($conn, "SELECT * FROM bankcustomer WHERE accNo = $accNoFrom");
                          if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_array($result);
                            if ($row['curBal'] >= $debitAmount) {
                              $result = mysqli_query($conn, "UPDATE bankcustomer SET curBal = curBal - $debitAmount WHERE accNo = $accNoFrom");
                              if ($result) {
                                $result = mysqli_query($conn, "UPDATE bankcustomer SET curBal = curBal + $debitAmount WHERE accNo = $accNoTo");
                                if ($result) {
                                  // 2-transfer
                                  // 1-Debit
                                  // 0-Deposit
                                  $sql = "INSERT INTO transactions (accNoTo, accNoFrom, amount, date, transType) VALUES ( '$accNoTo', '$accNoFrom', '$debitAmount', '$timestamp', 2)";
                                  if ($conn->query($sql) === TRUE) {
                                    echo '<div class="notify">Transaction Successful..!</div>';
                                  } else {
                                    echo '<div class="notify">Transaction Successful..!</div>';
                                    echo '<div class="warning">Record not stored..!</div>';
                                    echo "<div>Error: " . $sql . "<br>" . $conn->error."</div>";
                                  }
                                } else {
                                  echo '<div class="warning">Receivers\' account not responding..!</div>';
                                }
                              } else {
                                echo '<div class="warning">Senders\' account not responding..!</div>';
                              }
                            } else {
                              echo '<div class="warning">Insufficient balance in '.$row['accHolder'].'\'s [A/c No :'.$row['accNo'].'] account..!</div>';
                            }
                          } else {
                            echo '<div class="warning">Something went wrong, refresh page..!</div>';
                          }
                        } else {
                          echo '<div class="warning">Invalid amount..!</div>';
                        }
                      }
                    } else {
                      echo '<div class="warning">Account not found..!</div>';
                    }
                  } else if ($action == 'deposit') {
                    $result = mysqli_query($conn, "SELECT * FROM bankcustomer WHERE accNo = $accountNo");
                    if (mysqli_num_rows($result) > 0) {
                      $row = mysqli_fetch_array($result);
                    ?>
                    <form class="" action="" method="post">
                    <table class="info trans">
                      <caption>Deposit</caption>
                      <tr>
                        <td style="text-align: left;">To</td>
                      </tr>
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
                        <td style="text-align: left;">Amount</td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <input type="number" name="amount" value="0" min="100" class="fontt" max="10000000">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <input type="submit" name="deposit" value="Confirm" title="Confirm" class="fontt btnBack">
                          <a onclick="window.history.back();" class="fontt btnBack" title="Cancel">Cancel</a>
                        </td>
                      </tr>
                    </table>
                    </form>
                    <?php
                      if (isset($_POST['deposit'])) {
                        if (is_numeric($_POST['amount'])) {
                          $depositAmount = $_POST['amount'];
                          $accNoTo = $_GET['accNo'];
                          $result = mysqli_query($conn, "SELECT * FROM bankcustomer WHERE accNo = $accNoTo");
                          if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_array($result);
                            $result = mysqli_query($conn, "UPDATE bankcustomer SET curBal = curBal + $depositAmount WHERE accNo = $accNoTo");
                            if ($result) {
                              // 2-transfer
                              // 1-Debit
                              // 0-Deposit
                              $sql = "INSERT INTO transactions (accNoTo, accNoFrom, amount, date, transType) VALUES ( '$accNoTo', 0, '$depositAmount', '$timestamp', 0)";
                              if ($conn->query($sql) === TRUE) {
                                echo '<div class="notify">Transaction Successful..!</div>';
                              } else {
                                echo '<div class="notify">Transaction Successful..!</div>';
                                echo '<div class="warning">Record not stored..!</div>';
                                echo "<div>Error: " . $sql . "<br>" . $conn->error."</div>";
                              }
                            } else {
                              echo '<div class="warning">Receivers\' account not responding..!</div>';
                            }
                          } else {
                            echo '<div class="warning">Invalid amount..!</div>';
                          }
                        }
                      }
                    } else {
                      echo '<div class="warning">Account not found..!</div>';
                    }
                    //end of deposit
                  } else if ($action == 'debit') {
                    $result = mysqli_query($conn, "SELECT * FROM bankcustomer WHERE accNo = $accountNo");
                    if (mysqli_num_rows($result) > 0) {
                      $row = mysqli_fetch_array($result);
                    ?>
                    <form class="" action="" method="post">
                    <table class="info trans">
                      <caption style="background-color: rgba(255, 0, 0, 0.7);">Debit</caption>
                      <tr>
                        <td style="text-align: left;">From</td>
                      </tr>
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
                        <td style="text-align: left;">Amount</td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <input type="number" name="amount" value="0" min="100" class="fontt" max="10000000">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <input type="submit" name="debit" value="Confirm" title="Confirm" class="fontt btnBack">
                          <a onclick="window.history.back();" class="fontt btnBack" title="Cancel">Cancel</a>
                        </td>
                      </tr>
                    </table>
                    </form>
                    <?php
                      if (isset($_POST['debit'])) {
                        if (is_numeric($_POST['amount'])) {
                          $debitAmount = $_POST['amount'];
                          $accNoFrom = $_GET['accNo'];
                          $result = mysqli_query($conn, "SELECT * FROM bankcustomer WHERE accNo = $accNoFrom");
                          if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_array($result);
                            if ($row['curBal'] >= $debitAmount) {
                              $result = mysqli_query($conn, "UPDATE bankcustomer SET curBal = curBal - $debitAmount WHERE accNo = $accNoFrom");
                              if ($result) {
                                // 2-transfer
                                // 1-Debit
                                // 0-Deposit
                                $sql = "INSERT INTO transactions (accNoTo, accNoFrom, amount, date, transType) VALUES ( 0, $accNoFrom, '$debitAmount', '$timestamp', 1)";
                                if ($conn->query($sql) === TRUE) {
                                  echo '<div class="notify">Transaction Successful..!</div>';
                                } else {
                                  echo '<div class="notify">Transaction Successful..!</div>';
                                  echo '<div class="warning">Record not stored..!</div>';
                                  echo "<div>Error: " . $sql . "<br>" . $conn->error."</div>";
                                }
                              } else {
                                echo '<div class="warning">Senders\' account not responding..!</div>';
                              }
                            } else {
                              echo '<div class="warning">Insufficient balance in '.$row['accHolder'].'\'s [A/c No :'.$row['accNo'].'] account..!</div>';
                            }
                          } else {
                            echo '<div class="warning">Invalid amount..!</div>';
                          }
                        }
                      }
                    } else {
                      echo '<div class="warning">Account not found..!</div>';
                    }
                    //end of debit
                  } else {
                    echo '<div class="warning">Incorrect action..!</div>';
                  }
                } else {
                  echo '<div class="warning">Invalid action..!</div>';
                }
              } else {
                echo '<div class="warning">Action is missing..!</div>';
              }
            } else {
              echo '<div class="warning">Incorrect Account Number..!</div>';
            }
          } else {
            $result = mysqli_query($conn, "SELECT * FROM transactions;");
        ?>
        <a href="" style="text-decoration: none; padding: 8px 22px; background-color: rgba(255, 0, 0, 0.5); color: white;">Refresh</a>
        <table id="transList" class="trans history" style="width: 60em;" border>
          <caption>Transactions</caption>
          <tr>
            <th>S. No.</th>
            <th>To Account</th>
            <th>From Account</th>
            <th>Transaction Type</th>
            <th>Transaction Amount</th>
            <th>Date</th>
          </tr>
          <?php while($row = mysqli_fetch_array($result)) { ?>
            <tr>
              <td><?php echo $row['sno']; ?></td>
              <td><?php if ($row['accNoTo'] == 0) { echo "&minus;"; } else { echo $row['accNoTo']; } ?></td>
              <td><?php if ($row['accNoFrom'] == 0) { echo "&minus;"; } else { echo $row['accNoFrom']; } ?></td>
              <?php
                if ($row['transType'] == 0) {
                  echo '<td>Deposit</td>';
                  echo '<td class="deposit rightContent">&plus; ';
                  echo '<script type="text/javascript"> document.write(new Intl.NumberFormat("en-IN", { style: "currency", currency: "INR" }).format('.$row['amount'].'));</script>';
                  echo '</td>';
                } else if ($row['transType'] == 1) {
                  echo '<td>Debit</td>';
                  echo '<td class="debit rightContent">&minus; ';
                  echo '<script type="text/javascript"> document.write(new Intl.NumberFormat("en-IN", { style: "currency", currency: "INR" }).format('.$row['amount'].'));</script>';
                  echo '</td>';
                } else {
                  echo '<td>Direct Transfer</td>';
                  echo '<td class="transfer rightContent"> ';
                  echo '<script type="text/javascript"> document.write(new Intl.NumberFormat("en-IN", { style: "currency", currency: "INR" }).format('.$row['amount'].'));</script>';
                  echo '</td>';
                }
               ?>
               <td><?php echo $row['date']; ?></td>
          <?php } ?>
          </tr>
        </table>
      <?php } ?>
      </section>
      <hr>
      <footer>
        <p>&copy; 2021, i Bank. All rights reserved | Privacy Policy | Terms of Use | Investors</p>
      </footer>
    </center>
    <script type="text/javascript">
      var obj = document.getElementById("transList");
      var accNos = document.getElementById("accNos");
      var accHos = document.getElementById("accHos");
      function showTransactions() {
        if (obj.style.display == "none") {
          obj.style.display = "block";
        } else {
          obj.style.display =  "none";
        }
      }
      function showName(obj) {
        accHos.selectedIndex = obj.selectedIndex;
      }
    </script>
  </body>
</html>
