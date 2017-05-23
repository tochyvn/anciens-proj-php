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
 * Base class that represents a query for the 'MISE' table.
 *
 *
 *
 * @method     ChildMiseQuery orderByIdEnch($order = Criteria::ASC) Order by the id_ench column
 * @method     ChildMiseQuery orderByPseudo($order = Criteria::ASC) Order by the pseudo column
 * @method     ChildMiseQuery orderByPasswd($order = Criteria::ASC) Order by the passwd column
 * @method     ChildMiseQuery orderByPrix($order = Criteria::ASC) Order by the prix column
 *
 * @method     ChildMiseQuery groupByIdEnch() Group by the id_ench column
 * @method     ChildMiseQuery groupByPseudo() Group by the pseudo column
 * @method     ChildMiseQuery groupByPasswd() Group by the passwd column
 * @method     ChildMiseQuery groupByPrix() Group by the prix column
 *
 * @method     ChildMiseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMiseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMiseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMiseQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildMiseQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildMiseQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildMiseQuery leftJoinEnchere($relationAlias = null) Adds a LEFT JOIN clause to the query using the Enchere relation
 * @method     ChildMiseQuery rightJoinEnchere($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Enchere relation
 * @method     ChildMiseQuery innerJoinEnchere($relationAlias = null) Adds a INNER JOIN clause to the query using the Enchere relation
 *
 * @method     \UserQuery|\EnchereQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMise findOne(ConnectionInterface $con = null) Return the first ChildMise matching the query
 * @method     ChildMise findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMise matching the query, or a new ChildMise object populated from the query conditions when no match is found
 *
 * @method     ChildMise findOneByIdEnch(int $id_ench) Return the first ChildMise filtered by the id_ench column
 * @method     ChildMise findOneByPseudo(string $pseudo) Return the first ChildMise filtered by the pseudo column
 * @method     ChildMise findOneByPasswd(string $passwd) Return the first ChildMise filtered by the passwd column
 * @method     ChildMise findOneByPrix(double $prix) Return the first ChildMise filtered by the prix column *

 * @method     ChildMise requirePk($key, ConnectionInterface $con = null) Return the ChildMise by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOne(ConnectionInterface $con = null) Return the first ChildMise matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMise requireOneByIdEnch(int $id_ench) Return the first ChildMise filtered by the id_ench column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOneByPseudo(string $pseudo) Return the first ChildMise filtered by the pseudo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOneByPasswd(string $passwd) Return the first ChildMise filtered by the passwd column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOneByPrix(double $prix) Return the first ChildMise filtered by the prix column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMise[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMise objects based on current ModelCriteria
 * @method     ChildMise[]|ObjectCollection findByIdEnch(int $id_ench) Return ChildMise objects filtered by the id_ench column
 * @method     ChildMise[]|ObjectCollection findByPseudo(string $pseudo) Return ChildMise objects filtered by the pseudo column
 * @method     ChildMise[]|ObjectCollection findByPasswd(string $passwd) Return ChildMise objects filtered by the passwd column
 * @method     ChildMise[]|ObjectCollection findByPrix(double $prix) Return ChildMise objects filtered by the prix column
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
    public function __construct($dbName = 'SITE_ENCHERES', $modelName = '\\Mise', $modelAlias = null)
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
     * $obj = $c->findPk(array(12, 34, 56, 78), $con);
     * </code>
     *
     * @param array[$id_ench, $pseudo, $passwd, $prix] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMise|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MiseTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2], (string) $key[3]))))) && !$this->formatter) {
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
        $sql = 'SELECT id_ench, pseudo, passwd, prix FROM MISE WHERE id_ench = :p0 AND pseudo = :p1 AND passwd = :p2 AND prix = :p3';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_STR);
            $stmt->bindValue(':p3', $key[3], PDO::PARAM_STR);
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
            MiseTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1], (string) $key[2], (string) $key[3])));
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
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(MiseTableMap::COL_ID_ENCH, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(MiseTableMap::COL_PSEUDO, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(MiseTableMap::COL_PASSWD, $key[2], Criteria::EQUAL);
        $this->addUsingAlias(MiseTableMap::COL_PRIX, $key[3], Criteria::EQUAL);

        return $this;
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
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(MiseTableMap::COL_ID_ENCH, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(MiseTableMap::COL_PSEUDO, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(MiseTableMap::COL_PASSWD, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $cton3 = $this->getNewCriterion(MiseTableMap::COL_PRIX, $key[3], Criteria::EQUAL);
            $cton0->addAnd($cton3);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id_ench column
     *
     * Example usage:
     * <code>
     * $query->filterByIdEnch(1234); // WHERE id_ench = 1234
     * $query->filterByIdEnch(array(12, 34)); // WHERE id_ench IN (12, 34)
     * $query->filterByIdEnch(array('min' => 12)); // WHERE id_ench > 12
     * </code>
     *
     * @see       filterByEnchere()
     *
     * @param     mixed $idEnch The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByIdEnch($idEnch = null, $comparison = null)
    {
        if (is_array($idEnch)) {
            $useMinMax = false;
            if (isset($idEnch['min'])) {
                $this->addUsingAlias(MiseTableMap::COL_ID_ENCH, $idEnch['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idEnch['max'])) {
                $this->addUsingAlias(MiseTableMap::COL_ID_ENCH, $idEnch['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MiseTableMap::COL_ID_ENCH, $idEnch, $comparison);
    }

    /**
     * Filter the query on the pseudo column
     *
     * Example usage:
     * <code>
     * $query->filterByPseudo('fooValue');   // WHERE pseudo = 'fooValue'
     * $query->filterByPseudo('%fooValue%'); // WHERE pseudo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pseudo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByPseudo($pseudo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pseudo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pseudo)) {
                $pseudo = str_replace('*', '%', $pseudo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MiseTableMap::COL_PSEUDO, $pseudo, $comparison);
    }

    /**
     * Filter the query on the passwd column
     *
     * Example usage:
     * <code>
     * $query->filterByPasswd('fooValue');   // WHERE passwd = 'fooValue'
     * $query->filterByPasswd('%fooValue%'); // WHERE passwd LIKE '%fooValue%'
     * </code>
     *
     * @param     string $passwd The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByPasswd($passwd = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($passwd)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $passwd)) {
                $passwd = str_replace('*', '%', $passwd);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MiseTableMap::COL_PASSWD, $passwd, $comparison);
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
     * Filter the query by a related \User object
     *
     * @param \User $user The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMiseQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(MiseTableMap::COL_PSEUDO, $user->getPseudo(), $comparison)
                ->addUsingAlias(MiseTableMap::COL_PASSWD, $user->getPasswd(), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \User');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\UserQuery');
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
                ->addUsingAlias(MiseTableMap::COL_ID_ENCH, $enchere->getIdEnch(), $comparison);
        } elseif ($enchere instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MiseTableMap::COL_ID_ENCH, $enchere->toKeyValue('PrimaryKey', 'IdEnch'), $comparison);
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
    public function joinEnchere($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useEnchereQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
            $this->addCond('pruneCond0', $this->getAliasedColName(MiseTableMap::COL_ID_ENCH), $mise->getIdEnch(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(MiseTableMap::COL_PSEUDO), $mise->getPseudo(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(MiseTableMap::COL_PASSWD), $mise->getPasswd(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond3', $this->getAliasedColName(MiseTableMap::COL_PRIX), $mise->getPrix(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2', 'pruneCond3'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the MISE table.
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
