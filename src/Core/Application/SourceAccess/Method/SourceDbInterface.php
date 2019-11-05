<?php

namespace App\Core\Application\SourceAccess\Method;

use App\Core\Application\DataTransfer\Dto\SourceDbDto;

interface SourceDbInterface
{
    const RESULT_ASSOC = MYSQLI_ASSOC;
    const RESULT_NUM = MYSQLI_NUM;

    public function __construct(SourceDbDto $sourceDbDto);

    /**
     * Conventional function to run a query with placeholders.
     *
     * Examples:
     * $db->query("DELETE FROM table WHERE id=?i", $id);
     *
     * @param string $query    - an SQL query with placeholders
     * @param mixed  $args,... unlimited number of arguments to match placeholders in the query
     *
     * @return resource|false
     */
    public function query(string $query, ...$args);

    /**
     * Conventional function to fetch single row.
     *
     * @param resource $result - myqli result
     * @param int      $mode   - optional fetch mode, RESULT_ASSOC|RESULT_NUM, default RESULT_ASSOC
     *
     * @return array|false
     */
    public function fetch($result, $mode = self::RESULT_ASSOC);

    /**
     * Conventional function to get number of affected rows.
     *
     * @return int
     */
    public function affectedRows();

    /**
     * Conventional function to get last insert id.
     *
     * @return int whatever mysqli_insert_id returns
     */
    public function insertId();

    /**
     * Conventional function to get number of rows in the resultset.
     *
     * @param resource $result - myqli result
     *
     * @return int whatever mysqli_num_rows returns
     */
    public function numRows($result);

    /**
     * Conventional function to free the resultset.
     */
    public function free($result);

    /**
     * Helper function to get scalar value right out of query and optional arguments.
     *
     * Examples:
     * $name = $db->getOne("SELECT name FROM table WHERE id=1");
     * $name = $db->getOne("SELECT name FROM table WHERE id=?i", $id);
     *
     * @param string $query    - an SQL query with placeholders
     * @param mixed  $args,... unlimited number of arguments to match placeholders in the query
     *
     * @return string|false either first column of the first row of resultset or FALSE if none found
     */
    public function getOne(string $query, ...$args);

    /**
     * Helper function to get single row right out of query and optional arguments.
     *
     * Examples:
     * $data = $db->getRow("SELECT * FROM table WHERE id=1");
     * $data = $db->getRow("SELECT * FROM table WHERE id=?i", $id);
     *
     * @param string $query    - an SQL query with placeholders
     * @param mixed  $args,... unlimited number of arguments to match placeholders in the query
     *
     * @return array|false either associative array contains first row of resultset or FALSE if none found
     */
    public function getRow(string $query, ...$args);

    /**
     * Helper function to get single column right out of query and optional arguments.
     *
     * Examples:
     * $ids = $db->getCol("SELECT id FROM table WHERE cat=1");
     * $ids = $db->getCol("SELECT id FROM tags WHERE tagname = ?s", $tag);
     *
     * @param string $query    - an SQL query with placeholders
     * @param mixed  $args,... unlimited number of arguments to match placeholders in the query
     *
     * @return array|false either enumerated array of first fields of all rows of resultset or FALSE if none found
     */
    public function getCol(string $query, ...$args);

    /**
     * Helper function to get all the rows of resultset right out of query and optional arguments.
     *
     * Examples:
     * $data = $db->getAll("SELECT * FROM table");
     * $data = $db->getAll("SELECT * FROM table LIMIT ?i,?i", $start, $rows);
     *
     * @param string $query    - an SQL query with placeholders
     * @param mixed  $args,... unlimited number of arguments to match placeholders in the query
     *
     * @return array|false enumerated 2d array contains the resultset. False if no rows found.
     */
    public function getAll(string $query, ...$args);

    /**
     * Helper function to get all the rows of resultset into indexed array right out of query and optional arguments.
     *
     * Examples:
     * $data = $db->getInd("id", "SELECT * FROM table");
     * $data = $db->getInd("id", "SELECT * FROM table LIMIT ?i,?i", $start, $rows);
     *
     * @param string $index    - name of the field which value is used to index resulting array
     * @param string $query    - an SQL query with placeholders
     * @param mixed  $args,... unlimited number of arguments to match placeholders in the query
     *
     * @return array|false - associative 2d array contains the resultset. False if no rows found.
     */
    public function getInd(string $index, string $query, ...$args);

    /**
     * Helper function to get a dictionary-style array right out of query and optional arguments.
     *
     * Examples:
     * $data = $db->getIndCol("name", "SELECT name, id FROM cities");
     *
     * @param string $index   - name of the field which value is used to index resulting array
     * @param string $query   - an SQL query with placeholders
     * @param mixed  $args... unlimited number of arguments to match placeholders in the query
     *
     * @return array|false - associative array contains key=value pairs out of resultset. False if no rows found.
     */
    public function getIndCol(string $index, string $query, ...$args);

    /**
     * Function to parse placeholders either in the full query or a query part
     * unlike native prepared statements, allows ANY query part to be parsed.
     *
     * useful for debug
     * and EXTREMELY useful for conditional query building
     * like adding various query parts using loops, conditions, etc.
     * already parsed parts have to be added via ?p placeholder
     *
     * Examples:
     * $query = $db->parse("SELECT * FROM table WHERE foo=?s AND bar=?s", $foo, $bar);
     * echo $query;
     *
     * if ($foo) {
     *     $qpart = $db->parse(" AND foo=?s", $foo);
     * }
     * $data = $db->getAll("SELECT * FROM table WHERE bar=?s ?p", $bar, $qpart);
     *
     * @param string $query    - whatever expression contains placeholders
     * @param mixed  $args,... unlimited number of arguments to match placeholders in the expression
     *
     * @return string - initial expression with placeholders substituted with data
     */
    public function parse(string $query, ...$args);

    /**
     * function to implement whitelisting feature
     * sometimes we can't allow a non-validated user-supplied data to the query even through placeholder
     * especially if it comes down to SQL OPERATORS.
     *
     * Example:
     *
     * $order = $db->whiteList($_GET['order'], array('name','price'));
     * $dir   = $db->whiteList($_GET['dir'],   array('ASC','DESC'));
     * if (!$order || !dir) {
     *     throw new http404(); //non-expected values should cause 404 or similar response
     * }
     * $sql  = "SELECT * FROM table ORDER BY ?p ?p LIMIT ?i,?i"
     * $data = $db->getArr($sql, $order, $dir, $start, $per_page);
     *
     * @param string      $input   - field name to test
     * @param array       $allowed - an array with allowed variants
     * @param string|bool $default - optional variable to set if no match found. Default to false.
     *
     * @return string|false - either sanitized value or FALSE
     */
    public function whiteList(string $input, array $allowed, $default = false);

    /**
     * function to filter out arrays, for the whitelisting purposes
     * useful to pass entire superglobal to the INSERT or UPDATE query
     * OUGHT to be used for this purpose,
     * as there could be fields to which user should have no access to.
     *
     * Example:
     * $allowed = array('title','url','body','rating','term','type');
     * $data    = $db->filterArray($_POST,$allowed);
     * $sql     = "INSERT INTO ?n SET ?u";
     * $db->query($sql,$table,$data);
     *
     * @param array $input   - source array
     * @param array $allowed - an array with allowed field names
     *
     * @return array filtered out source array
     */
    public function filterArray(array $input, array $allowed);

    /**
     * Function to get last executed query.
     *
     * @return string|null either last executed query or NULL if were none
     */
    public function lastQuery();

    /**
     * Function to get all query statistics.
     *
     * @return array|null contains all executed queries with timings and errors or NULL if were none
     */
    public function getStats();
}
