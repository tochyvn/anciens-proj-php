<?php

namespace Base;

use \Utilisateur as ChildUtilisateur;
use \UtilisateurQuery as ChildUtilisateurQuery;
use \Exception;
use \PDO;
use Map\UtilisateurTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Utilisateur' table.
 *
 *
 *
 * @method     ChildUtilisateurQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUtilisateurQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildUtilisateurQuery orderByPseudo($order = Criteria::ASC) Order by the pseudo column
 * @method     ChildUtilisateurQuery orderByRole($order = Criteria::ASC) Order by the role column
 *
 * @method     ChildUtilisateurQuery groupByEmail() Group by the email column
 * @method     ChildUtilisateurQuery groupByPassword() Group by the password column
 * @method     ChildUtilisateurQuery groupByPseudo() Group by the pseudo column
 * @method     ChildUtilisateurQuery groupByRole() Group by the role column
 *
 * @method     ChildUtilisateurQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUtilisateurQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUtilisateurQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUtilisateurQuery leftJoinAchat($relationAlias = null) Adds a LEFT JOIN clause to the query using the Achat relation
 * @method     ChildUtilisateurQuery rightJoinAchat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Achat relation
 * @method     ChildUtilisateurQuery innerJoinAchat($relationAlias = null) Adds a INNER JOIN clause to the query using the Achat relation
 *
 * @method     ChildUtilisateurQuery leftJoinMise($relationAlias = null) Adds a LEFT JOIN clause to the query using the Mise relation
 * @method     ChildUtilisateurQuery rightJoinMise($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Mise relation
 * @method     ChildUtilisateurQuery innerJoinMise($relationAlias = null) Adds a INNER JOIN clause to the query using the Mise relation
 *
 * @method     \AchatQuery|\MiseQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUtilisateur findOne(ConnectionInterface $con = null) Return the first ChildUtilisateur matching the query
 * @method     ChildUtilisateur findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUtilisateur matching the query, or a new ChildUtilisateur object populated from the query conditions when no match is found
 *
 * @method     ChildUtilisateur findOneByEmail(string $email) Return the first ChildUtilisateur filtered by the email column
 * @method     ChildUtilisateur findOneByPassword(string $password) Return the first ChildUtilisateur filtered by the password column
 * @method     ChildUtilisateur findOneByPseudo(int $pseudo) Return the first ChildUtilisateur filtered by the pseudo column
 * @method     ChildUtilisateur findOneByRole(int $role) Return the first ChildUtilisateur filtered by the role column *

 * @method     ChildUtilisateur requirePk($key, ConnectionInterface $con = null) Return the ChildUtilisateur by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOne(ConnectionInterface $con = null) Return the first ChildUtilisateur matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUtilisateur requireOneByEmail(string $email) Return the first ChildUtilisateur filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOneByPassword(string $password) Return the first ChildUtilisateur filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOneByPseudo(int $pseudo) Return the first ChildUtilisateur filtered by the pseudo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOneByRole(int $role) Return the first ChildUtilisateur filtered by the role column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUtilisateur[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUtilisateur objects based on current ModelCriteria
 * @method     ChildUtilisateur[]|ObjectCollection findByEmail(string $email) Return ChildUtilisateur objects filtered by the email column
 * @method     ChildUtilisateur[]|ObjectCollection findByPassword(string $password) Return ChildUtilisateur objects filtered by the password column
 * @method     ChildUtilisateur[]|ObjectCollection findByPseudo(int $pseudo) Return ChildUtilisateur objects filtered by the pseudo column
 * @method     ChildUtilisateur[]|ObjectCollection findByRole(int $role) Return ChildUtilisateur objects filtered by the role column
 * @method     ChildUtilisateur[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UtilisateurQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UtilisateurQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'miniprojet', $modelName = '\\Utilisateur', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUtilisateurQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUtilisateurQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUtilisateurQuery) {
            return $criteria;
        }
        $query = new ChildUtilisateurQuery();
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
     * @return ChildUtilisateur|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UtilisateurTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UtilisateurTableMap::DATABASE_NAME);
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
     * @return ChildUtilisateur A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT email, password, pseudo, role FROM Utilisateur WHERE email = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildUtilisateur $obj */
            $obj = new ChildUtilisateur();
            $obj->hydrate($row);
            UtilisateurTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildUtilisateur|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UtilisateurTableMap::COL_EMAIL, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UtilisateurTableMap::COL_EMAIL, $keys, Criteria::IN);
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
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
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

        return $this->addUsingAlias(UtilisateurTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UtilisateurTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the pseudo column
     *
     * Example usage:
     * <code>
     * $query->filterByPseudo(1234); // WHERE pseudo = 1234
     * $query->filterByPseudo(array(12, 34)); // WHERE pseudo IN (12, 34)
     * $query->filterByPseudo(array('min' => 12)); // WHERE pseudo > 12
     * </code>
     *
     * @param     mixed $pseudo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByPseudo($pseudo = null, $comparison = null)
    {
        if (is_array($pseudo)) {
            $useMinMax = false;
            if (isset($pseudo['min'])) {
                $this->addUsingAlias(UtilisateurTableMap::COL_PSEUDO, $pseudo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pseudo['max'])) {
                $this->addUsingAlias(UtilisateurTableMap::COL_PSEUDO, $pseudo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UtilisateurTableMap::COL_PSEUDO, $pseudo, $comparison);
    }

    /**
     * Filter the query on the role column
     *
     * Example usage:
     * <code>
     * $query->filterByRole(1234); // WHERE role = 1234
     * $query->filterByRole(array(12, 34)); // WHERE role IN (12, 34)
     * $query->filterByRole(array('min' => 12)); // WHERE role > 12
     * </code>
     *
     * @param     mixed $role The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByRole($role = null, $comparison = null)
    {
        if (is_array($role)) {
            $useMinMax = false;
            if (isset($role['min'])) {
                $this->addUsingAlias(UtilisateurTableMap::COL_ROLE, $role['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($role['max'])) {
                $this->addUsingAlias(UtilisateurTableMap::COL_ROLE, $role['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UtilisateurTableMap::COL_ROLE, $role, $comparison);
    }

    /**
     * Filter the query by a related \Achat object
     *
     * @param \Achat|ObjectCollection $achat the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByAchat($achat, $comparison = null)
    {
        if ($achat instanceof \Achat) {
            return $this
                ->addUsingAlias(UtilisateurTableMap::COL_EMAIL, $achat->getEmail(), $comparison);
        } elseif ($achat instanceof ObjectCollection) {
            return $this
                ->useAchatQuery()
                ->filterByPrimaryKeys($achat->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAchat() only accepts arguments of type \Achat or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Achat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function joinAchat($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Achat');

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
            $this->addJoinObject($join, 'Achat');
        }

        return $this;
    }

    /**
     * Use the Achat relation Achat object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AchatQuery A secondary query class using the current class as primary query
     */
    public function useAchatQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAchat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Achat', '\AchatQuery');
    }

    /**
     * Filter the query by a related \Mise object
     *
     * @param \Mise|ObjectCollection $mise the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByMise($mise, $comparison = null)
    {
        if ($mise instanceof \Mise) {
            return $this
                ->addUsingAlias(UtilisateurTableMap::COL_EMAIL, $mise->getEmail(), $comparison);
        } elseif ($mise instanceof ObjectCollection) {
            return $this
                ->useMiseQuery()
                ->filterByPrimaryKeys($mise->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMise() only accepts arguments of type \Mise or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Mise relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function joinMise($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Mise');

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
            $this->addJoinObject($join, 'Mise');
        }

        return $this;
    }

    /**
     * Use the Mise relation Mise object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MiseQuery A secondary query class using the current class as primary query
     */
    public function useMiseQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMise($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Mise', '\MiseQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUtilisateur $utilisateur Object to remove from the list of results
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function prune($utilisateur = null)
    {
        if ($utilisateur) {
            $this->addUsingAlias(UtilisateurTableMap::COL_EMAIL, $utilisateur->getEmail(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Utilisateur table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UtilisateurTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UtilisateurTableMap::clearInstancePool();
            UtilisateurTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UtilisateurTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UtilisateurTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UtilisateurTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UtilisateurTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UtilisateurQuery
