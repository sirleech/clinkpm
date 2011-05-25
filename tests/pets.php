<?php
    /* database.php - Use mysql database from php
     * (c) 200309 Tero.Karvinen <at-sign> iki.fi, adapted from php.net 
     * See http://iki.fi/karvinen Linux Apache MySQL PHP tutorial. */

    /* Connect to database */
    $link = mysql_connect("localhost", "root", "ae1cam")
        or die("Could not connect : " . mysql_error());
    print "Connected successfully";
    mysql_select_db("menagerie") or die("Could not select database");

    /* Perform SQL query */
    $query = "SELECT * FROM pet";
    $result = mysql_query($query)
	or die("Query failed : " . mysql_error());

    /* Print results in HTML */
    print "<table border='1'>\n";
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        print "\t<tr>\n";
        foreach ($line as $col_value) {
            print "\t\t<td>$col_value</td>\n";
        }
        print "\t</tr>\n";
    }
    print "</table>\n";
    mysql_free_result($result);

    /* Close connection */
    mysql_close($link);
?>
