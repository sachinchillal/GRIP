<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>iBank</title>
    <link rel="icon" type="image/png" sizes="16x16" href="Bank16x16.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="iBank.css">
    <style media="screen">

      .charts {
        display: flex;
        justify-content: space-around;
        color: white;
        margin: 0;
        margin-top: 100px;
        /* background-color: red; */
      }
      .box {
        margin-top: 30px;
        min-height: 200px;
        min-width: 200px;
        border: 1px solid yellow;
        user-select: none;
        cursor: pointer;
        /* background-color: #888; */
      }
      .box:hover {
        background-color: #666;
        outline: 1px solid coral;
      }
      .box label {
        display: block;
        background-color: #99f;
        padding: 8px 16px;
        border: 1px solid #462;
        margin-top: 30px;
      }
      .box label:hover {
        background-color: rgba(255, 0, 0, 0);
        outline: 3px solid coral;
        border: 1px solid #99f;
      }
      .logo {
        display: block;
        padding: 10px;
        font-size: 100px;
      }
      section {
        margin: 0;
        /* background-color: blue; */
      }
    </style>
  </head>
  <body>
    <center>
      <section style="min-height: calc(100vh - 150px);">
        <a href=""><h1><span>i </span>Bank &#x1f3e6;</h1></a>
        <div class="navBar">
          <a href="accounts.php" class="link">View Accounts</a>
          <a href="transaction.php" class="link">View Transactions</a>
          <a href="accounts.php" class="link">Transfer Money</a>
          <a href="" class="link">Register</a>
          <a href="" class="link">SignIn</a>
          <a href="../index.php" class="link">Feedback</a>
          <a href="index.php" class="link">Home</a>
          <a onclick="window.history.back();" class="btnBack" title="Back">&#x21A9;</a>
        </div>
        <hr class="makeSpace">
        <div class="charts">
          <div class="box" id="account" onclick="location.href = 'accounts.php'" title="Click to view accounts">
            <span class="logo">&#x1F468;&#x200D;&#x1F469;&#x200D;&#x1F467;&#x200D;&#x1F466;</span>
            <label for="account">View Accounts</label>
          </div>
          <div class="box" id="transfer" onclick="location.href = 'transaction.php'"  title="Click to do transaction">
            <span class="logo">&#x1F4B1;</span>
            <label for="transfer">Make a Transaction</label>
          </div>
          <div class="box" id="history"  onclick="location.href = 'transaction.php'"  title="Click to view transactions">
            <span class="logo">&#x1F4C3;</span>
            <label for="history">View Transaction</label>
          </div>
        </div>
      </section>
      <hr>
      <footer>
        by <b>Sachin Chillal</b><br>
        <p>
          <a href=""><img src="TSF.png" alt="TSF" width="50"> </a> <br>
          GRIP @ The Sparks Foundation.
        </p>
      </footer>
    </center>
  </body>
</html>
