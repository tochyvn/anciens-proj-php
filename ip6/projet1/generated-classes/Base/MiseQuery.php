<?php

namespace Base;

use \Mise as ChildMise;
use \MiseQuery as ChildMiseQuery;
use \Exception;
use \PDO;
use Map\MiseTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Mise' table.
 *
 *
 *
 * @method     ChildMiseQuery orderByPrix($order = Criteria::ASC) Order by the prix column
 * @method     ChildMiseQuery orderByDateproposition($order = Criteria::ASC) Order by the dateProposition column
 * @method     ChildMiseQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildMiseQuery orderById($order = Criteria::ASC) Order by the id column
 *
 * @method     ChildMiseQuery groupByPrix() Group by the prix column
 * @method     ChildMiseQuery groupByDateproposition() Group by the dateProposition column
 * @method     ChildMiseQuery groupByEmail() Group by the email column
 * @method     ChildMiseQuery groupById() Group by the id column
 *
 * @method     ChildMiseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMiseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMiseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMiseQuery leftJoinUtilisateur($relationAlias = null) Adds a LEFT JOIN clause to the query using the Utilisateur relation
 * @method     ChildMiseQuery rightJoinUtilisateur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Utilisateur relation
 * @method     ChildMiseQuery innerJoinUtilisateur($relationAlias = null) Adds a INNER JOIN clause to the query using the Utilisateur relation
 *
 * @method     ChildMiseQuery leftJoinEnchere($relationAlias = null) Adds a LEFT JOIN clause to the query using the Enchere relation
 * @method     ChildMiseQuery rightJoinEnchere($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Enchere relation
 * @method     ChildMiseQuery innerJoinEnchere($relationAlias = null) Adds a INNER JOIN clause to the query using the Enchere relation
 *
 * @method     \UtilisateurQuery|\EnchereQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMise findOne(ConnectionInterface $con = null) Return the first ChildMise matching the query
 * @method     ChildMise findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMise matching the query, or a new ChildMise object populated from the query conditions when no match is found
 *
 * @method     ChildMise findOneByPrix(int $prix) Return the first ChildMise filtered by the prix column
 * @method     ChildMise findOneByDateproposition(string $dateProposition) Return the first ChildMise filtered by the dateProposition column
 * @method     ChildMise findOneByEmail(string $email) Return the first ChildMise filtered by the email column
 * @method     ChildMise findOneById(int $id) Return the first ChildMise filtered by the id column *

 * @method     ChildMise requirePk($key, ConnectionInterface $con = null) Return the ChildMise by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOne(ConnectionInterface $con = null) Return the first ChildMise matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMise requireOneByPrix(int $prix) Return the first ChildMise filtered by the prix column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOneByDateproposition(string $dateProposition) Return the first ChildMise filtered by the dateProposition column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOneByEmail(string $email) Return the first ChildMise filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOneById(int $id) Return the first ChildMise filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMise[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMise objects based on current ModelCriteria
 * @method     ChildMise[]|ObjectCollection findByPrix(int $prix) Return ChildMise objects filtered by the prix column
 * @method     ChildMise[]|ObjectCollection findByDateproposition(string $dateProposition) Return ChildMise objects filtered by the dateProposition column
 * @method     ChildMise[]|ObjectCollection findByEmail(string $email) Return ChildMise objects filtered by the email column
 * @method     ChildMise[]|ObjectCollection findById(int $id) Return ChildMise objects filtered by the id column
 * @method     ChildMise[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MiseQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MiseQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'miniprojet', $modelName = '\\Mise', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMiseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMiseQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMiseQuery) {
            return $criteria;
        }
        $query = new ChildMiseQuery();
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
     * @return ChildMise|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MiseTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MiseTableMap::DATABASE_NAME);
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
     * @return ChildMise A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT prix, dateProposition, email, id FROM Mise WHERE prix = :p0';
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
            /** @var ChildMise $obj */
            $obj = new ChildMise();
            $obj->hydrate($row);
            MiseTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMise|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MiseTableMap::COL_PRIX, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MiseTableMap::COL_PRIX, $keys, Criteria::IN);
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
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByPrix($prix = null, $comparison = null)
    {
        if (is_array($prix)) {
            $useMinMax = false;
            if (isset($prix['min'])) {
                $this->addUsingAlias(MiseTableMap::COL_PRIX, $prix['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prix['max'])) {
                $this->addUsingAlias(MiseTableMap::COL_PRIX, $prix['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MiseTableMap::COL_PRIX, $prix, $comparison);
    }

    /**
     * Filter the query on the dateProposition column
     *
     * Example usage:
     * <code>
     * $query->filterByDateproposition('2011-03-14'); // WHERE dateProposition = '2011-03-14'
     * $query->filterByDateproposition('now'); // WHERE dateProposition = '2011-03-14'
     * $query->filterByDateproposition(array('max' => 'yesterday')); // WHERE dateProposition > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateproposition The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByDateproposition($dateproposition = null, $comparison = null)
    {
        if (is_array($dateproposition)) {
            $useMinMax = false;
            if (isset($dateproposition['min'])) {
                $this->addUsingAlias(MiseTableMap::COL_DATEPROPOSITION, $dateproposition['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateproposition['max'])) {
                $this->addUsingAlias(MiseTableMap::COL_DATEPROPOSITION, $dateproposition['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MiseTableMap::COL_DATEPROPOSITION, $dateproposition, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MiseTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @see       filterByEnchere()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MiseTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MiseTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MiseTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query by a related \Utilisateur object
     *
     * @param \Utilisateur|ObjectCollection $utilisateur The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMiseQuery The current query, for fluid interface
     */
    public function filterByUtilisateur($utilisateur, $comparison = null)
    {
        if ($utilisateur instanceof \Utilisateur) {
            return $this
                ->addUsingAlias(MiseTableMap::COL_EMAIL, $utilisateur->getEmail(), $comparison);
        } elseif ($utilisateur instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MiseTableMap::COL_EMAIL, $utilisateur->toKeyValue('PrimaryKey', 'Email'), $comparison);
        } else {
            throw new PropelException('filterByUtilisateur() only accepts arguments of type \Utilisateur or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Utilisateur relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function joinUtilisateur($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Utilisateur');

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
            $this->addJoinObject($join, 'Utilisateur');
        }

        return $this;
    }

    /**
     * Use the Utilisateur relation Utilisateur object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UtilisateurQuery A secondary query class using the current class as primary query
     */
    public function useUtilisateurQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUtilisateur($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Utilisateur', '\UtilisateurQuery');
    }

    /**
     * Filter the query by a related \Enchere object
     *
     * @param \Enchere|ObjectCollection $enchere The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMiseQuery The current query, for fluid interface
     */
    public function filterByEnchere($enchere, $comparison = null)
    {
        if ($enchere instanceof \Enchere) {
            return $this
                ->addUsingAlias(MiseTableMap::COL_ID, $enchere->getId(), $comparison);
        } elseif ($enchere instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MiseTableMap::COL_ID, $enchere->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildMiseQuery The current query, for fluid interface
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
     * @param   ChildMise $mise Object to remove from the list of results
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function prune($mise = null)
    {
        if ($mise) {
            $this->addUsingAlias(MiseTableMap::COL_PRIX, $mise->getPrix(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Mise table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MiseTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MiseTableMap::clearInstancePool();
            MiseTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MiseTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MiseTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MiseTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MiseTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MiseQuery
