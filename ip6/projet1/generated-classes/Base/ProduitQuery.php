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
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Produit' table.
 *
 *
 *
 * @method     ChildProduitQuery orderByReference($order = Criteria::ASC) Order by the reference column
 * @method     ChildProduitQuery orderByDesignation($order = Criteria::ASC) Order by the designation column
 * @method     ChildProduitQuery orderByImage($order = Criteria::ASC) Order by the image column
 * @method     ChildProduitQuery orderByPrix($order = Criteria::ASC) Order by the prix column
 *
 * @method     ChildProduitQuery groupByReference() Group by the reference column
 * @method     ChildProduitQuery groupByDesignation() Group by the designation column
 * @method     ChildProduitQuery groupByImage() Group by the image column
 * @method     ChildProduitQuery groupByPrix() Group by the prix column
 *
 * @method     ChildProduitQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProduitQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProduitQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProduitQuery leftJoinEnchere($relationAlias = null) Adds a LEFT JOIN clause to the query using the Enchere relation
 * @method     ChildProduitQuery rightJoinEnchere($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Enchere relation
 * @method     ChildProduitQuery innerJoinEnchere($relationAlias = null) Adds a INNER JOIN clause to the query using the Enchere relation
 *
 * @method     \EnchereQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProduit findOne(ConnectionInterface $con = null) Return the first ChildProduit matching the query
 * @method     ChildProduit findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProduit matching the query, or a new ChildProduit object populated from the query conditions when no match is found
 *
 * @method     ChildProduit findOneByReference(int $reference) Return the first ChildProduit filtered by the reference column
 * @method     ChildProduit findOneByDesignation(string $designation) Return the first ChildProduit filtered by the designation column
 * @method     ChildProduit findOneByImage(string $image) Return the first ChildProduit filtered by the image column
 * @method     ChildProduit findOneByPrix(int $prix) Return the first ChildProduit filtered by the prix column *

 * @method     ChildProduit requirePk($key, ConnectionInterface $con = null) Return the ChildProduit by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProduit requireOne(ConnectionInterface $con = null) Return the first ChildProduit matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProduit requireOneByReference(int $reference) Return the first ChildProduit filtered by the reference column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProduit requireOneByDesignation(string $designation) Return the first ChildProduit filtered by the designation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProduit requireOneByImage(string $image) Return the first ChildProduit filtered by the image column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildProduit requireOneByPrix(int $prix) Return the first ChildProduit filtered by the prix column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildProduit[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildProduit objects based on current ModelCriteria
 * @method     ChildProduit[]|ObjectCollection findByReference(int $reference) Return ChildProduit objects filtered by the reference column
 * @method     ChildProduit[]|ObjectCollection findByDesignation(string $designation) Return ChildProduit objects filtered by the designation column
 * @method     ChildProduit[]|ObjectCollection findByImage(string $image) Return ChildProduit objects filtered by the image column
 * @method     ChildProduit[]|ObjectCollection findByPrix(int $prix) Return ChildProduit objects filtered by the prix column
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
    public function __construct($dbName = 'miniprojet', $modelName = '\\Produit', $modelAlias = null)
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$reference, $designation] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildProduit|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProduitTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
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
        $sql = 'SELECT reference, designation, image, prix FROM Produit WHERE reference = :p0 AND designation = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
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
            ProduitTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
        $this->addUsingAlias(ProduitTableMap::COL_REFERENCE, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ProduitTableMap::COL_DESIGNATION, $key[1], Criteria::EQUAL);

        return $this;
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
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ProduitTableMap::COL_REFERENCE, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ProduitTableMap::COL_DESIGNATION, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the reference column
     *
     * Example usage:
     * <code>
     * $query->filterByReference(1234); // WHERE reference = 1234
     * $query->filterByReference(array(12, 34)); // WHERE reference IN (12, 34)
     * $query->filterByReference(array('min' => 12)); // WHERE reference > 12
     * </code>
     *
     * @param     mixed $reference The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProduitQuery The current query, for fluid interface
     */
    public function filterByReference($reference = null, $comparison = null)
    {
        if (is_array($reference)) {
            $useMinMax = false;
            if (isset($reference['min'])) {
                $this->addUsingAlias(ProduitTableMap::COL_REFERENCE, $reference['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($reference['max'])) {
                $this->addUsingAlias(ProduitTableMap::COL_REFERENCE, $reference['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProduitTableMap::COL_REFERENCE, $reference, $comparison);
    }

    /**
     * Filter the query on the designation column
     *
     * Example usage:
     * <code>
     * $query->filterByDesignation('fooValue');   // WHERE designation = 'fooValue'
     * $query->filterByDesignation('%fooValue%'); // WHERE designation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $designation The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProduitQuery The current query, for fluid interface
     */
    public function filterByDesignation($designation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($designation)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $designation)) {
                $designation = str_replace('*', '%', $designation);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProduitTableMap::COL_DESIGNATION, $designation, $comparison);
    }

    /**
     * Filter the query on the image column
     *
     * Example usage:
     * <code>
     * $query->filterByImage('fooValue');   // WHERE image = 'fooValue'
     * $query->filterByImage('%fooValue%'); // WHERE image LIKE '%fooValue%'
     * </code>
     *
     * @param     string $image The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProduitQuery The current query, for fluid interface
     */
    public function filterByImage($image = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($image)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $image)) {
                $image = str_replace('*', '%', $image);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProduitTableMap::COL_IMAGE, $image, $comparison);
    }

    /**
     * Filter the query on the prix column
     *
     * Example usage:
     * <code>
     * $query->filterByPrix(1234); // WHERE prix = 1234
     * $query->filterByPrix(array(12, 34)); // WHERE prix IN (12, 34)
     * $query->filterByPrix(array('min' => 12)); // WHERE prix > 12
     * </code>
     *
     * @param     mixed $prix The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProduitQuery The current query, for fluid interface
     */
    public function filterByPrix($prix = null, $comparison = null)
    {
        if (is_array($prix)) {
            $useMinMax = false;
            if (isset($prix['min'])) {
                $this->addUsingAlias(ProduitTableMap::COL_PRIX, $prix['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prix['max'])) {
                $this->addUsingAlias(ProduitTableMap::COL_PRIX, $prix['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProduitTableMap::COL_PRIX, $prix, $comparison);
    }

    /**
     * Filter the query by a related \Enchere object
     *
     * @param \Enchere|ObjectCollection $enchere the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProduitQuery The current query, for fluid interface
     */
    public function filterByEnchere($enchere, $comparison = null)
    {
        if ($enchere instanceof \Enchere) {
            return $this
                ->addUsingAlias(ProduitTableMap::COL_REFERENCE, $enchere->getReference(), $comparison);
        } elseif ($enchere instanceof ObjectCollection) {
            return $this
                ->useEnchereQuery()
                ->filterByPrimaryKeys($enchere->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEnchere() only accepts arguments of type \Enchere or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Enchere relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProduitQuery The current query, for fluid interface
     */
    public function joinEnchere($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Enchere');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Enchere');
        }

        return $this;
    }

    /**
     * Use the Enchere relation Enchere object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EnchereQuery A secondary query class using the current class as primary query
     */
    public function useEnchereQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEnchere($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Enchere', '\EnchereQuery');
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
            $this->addCond('pruneCond0', $this->getAliasedColName(ProduitTableMap::COL_REFERENCE), $produit->getReference(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ProduitTableMap::COL_DESIGNATION), $produit->getDesignation(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Produit table.
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
