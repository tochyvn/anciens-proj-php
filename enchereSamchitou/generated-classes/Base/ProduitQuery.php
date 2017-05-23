<?php

namespace Base;

use \Produit as ChildProduit;
use \ProduitQuery as ChildProduitQuery;
use \Exception;
use \PDO;
use Map\ProduitTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'produit' table.
 *
 *
 *
 * @method     ChildProduitQuery orderByRefProduit($order = Criteria::ASC) Order by the ref_produit column
 * @method     ChildProduitQuery orderByProduit($order = Criteria::ASC) Order by the produit column
 *
 * @method     ChildProduitQuery groupByRefProduit() Group by the ref_produit column
 * @method     ChildProduitQuery groupByProduit() Group by the produit column
 *
 * @method     ChildProduitQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProduitQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProduitQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProduitQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildProduitQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildProduitQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildProduit findOne(ConnectionInterface $con = null) Return the first ChildProduit matching the query
 * @method     ChildProduit findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProduit matching the query, or a new ChildProduit object populated from the query conditions when no match is found
 *
 * @method     ChildProduit findOneByRefProduit(int $ref_produit) Return the first ChildProduit filtered by the ref_produit column
 * @method     ChildProduit findOneByProduit(string $produit) Return the first ChildProduit filtered by the produit column *

 * @method     ChildProduit requirePk($key, ConnectionInterface $con = null) Return the ChildProduit by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProduit requireOne(ConnectionInterface $con = null) Return the first ChildProduit matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProduit requireOneByRefProduit(int $ref_produit) Return the first ChildProduit filtered by the ref_produit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProduit requireOneByProduit(string $produit) Return the first ChildProduit filtered by the produit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProduit[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildProduit objects based on current ModelCriteria
 * @method     ChildProduit[]|ObjectCollection findByRefProduit(int $ref_produit) Return ChildProduit objects filtered by the ref_produit column
 * @method     ChildProduit[]|ObjectCollection findByProduit(string $produit) Return ChildProduit objects filtered by the produit column
 * @method     ChildProduit[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ProduitQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ProduitQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'encheres', $modelName = '\\Produit', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProduitQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProduitQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildProduitQuery) {
            return $criteria;
        }
        $query = new ChildProduitQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildProduit|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProduitTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProduitTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildProduit A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ref_produit, produit FROM produit WHERE ref_produit = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildProduit $obj */
            $obj = new ChildProduit();
            $obj->hydrate($row);
            ProduitTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildProduit|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildProduitQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProduitTableMap::COL_REF_PRODUIT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildProduitQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProduitTableMap::COL_REF_PRODUIT, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the ref_produit column
     *
     * Example usage:
     * <code>
     * $query->filterByRefProduit(1234); // WHERE ref_produit = 1234
     * $query->filterByRefProduit(array(12, 34)); // WHERE ref_produit IN (12, 34)
     * $query->filterByRefProduit(array('min' => 12)); // WHERE ref_produit > 12
     * </code>
     *
     * @param     mixed $refProduit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProduitQuery The current query, for fluid interface
     */
    public function filterByRefProduit($refProduit = null, $comparison = null)
    {
        if (is_array($refProduit)) {
            $useMinMax = false;
            if (isset($refProduit['min'])) {
                $this->addUsingAlias(ProduitTableMap::COL_REF_PRODUIT, $refProduit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($refProduit['max'])) {
                $this->addUsingAlias(ProduitTableMap::COL_REF_PRODUIT, $refProduit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProduitTableMap::COL_REF_PRODUIT, $refProduit, $comparison);
    }

    /**
     * Filter the query on the produit column
     *
     * Example usage:
     * <code>
     * $query->filterByProduit('fooValue');   // WHERE produit = 'fooValue'
     * $query->filterByProduit('%fooValue%'); // WHERE produit LIKE '%fooValue%'
     * </code>
     *
     * @param     string $produit The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProduitQuery The current query, for fluid interface
     */
    public function filterByProduit($produit = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($produit)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $produit)) {
                $produit = str_replace('*', '%', $produit);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProduitTableMap::COL_PRODUIT, $produit, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProduit $produit Object to remove from the list of results
     *
     * @return $this|ChildProduitQuery The current query, for fluid interface
     */
    public function prune($produit = null)
    {
        if ($produit) {
            $this->addUsingAlias(ProduitTableMap::COL_REF_PRODUIT, $produit->getRefProduit(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the produit table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProduitTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProduitTableMap::clearInstancePool();
            ProduitTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProduitTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProduitTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ProduitTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProduitTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ProduitQuery
