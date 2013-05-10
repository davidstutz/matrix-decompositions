<!DOCTYPE html>
<html>
	<head>
		<title><?php echo __('Matrix Decompositions'); ?></title>
		<script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/jquery.min.js"></script>
    <script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://c328740.ssl.cf1.rackcdn.com/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
    <script type="text/javascript" src="/<?php echo $app->config('base'); ?>/Assets/Js/prettify.js"></script>
    <script type="text/x-mathjax-config">
      MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
      });
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
        window.prettyPrint() && prettyPrint();
      });
    </script>
    <link rel="stylesheet" type="text/css" href="/<?php echo $app->config('base'); ?>/Assets/Css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/<?php echo $app->config('base'); ?>/Assets/Css/matrix-decompositions.css">
    <link rel="stylesheet" type="text/css" href="/<?php echo $app->config('base'); ?>/Assets/Css/prettify.css">
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<h1><?php echo __('Matrix Decompositions'); ?></h1>
			</div>
			
			<div class="row">
			  <div class="span3">
    	    <ul class="nav nav-pills nav-stacked">
            <li class="active">
              <a href="#"><?php echo __('Matrix Decompositions'); ?></a>
              <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/cholesky'); ?>"><?php echo __('Cholesky Decomposition'); ?></a></li>
                <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/qr'); ?>"><?php echo __('QR Decomposition'); ?></a></li>
              </ul>
            <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a></li>
            <li><a href="/<?php echo $app->config('base') . $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
          </ul>
    	</div>
    	<div class="span9">
    			<p>
    				<?php echo __('In computer science a lot of applications lead to the problem of solving systems of linear equations. In linear algebra the problem is specified as follows:'); ?>
    			</p>
    			
    			<p>
    				<b><?php echo __('Problem.'); ?></b> <?php echo __('Given $A \in \mathbb{R}^{n \times n}$ and $b \in \mathbb{R}^n$. Find $x \in \mathbb{R}^n$ such that $Ax = b$.'); ?>
    			</p>
    			
    			<p>
    				<?php echo __('In this experiment we want to examine some numerical methods to solve this problem implemented in PHP.'); ?>
    			</p>
    			
    			<p>
    				<b><?php echo __('Remark.'); ?></b> <?php echo __('If $A$ is regular the following statements hold:'); ?>
    				<ul>
    					<li><?php echo __('$det(A) \neq 0$'); ?></li>
    					<li><?php echo __('The system $Ax = b$ has a single unique solution for each $b \in \mathbb{R}^n$.'); ?></li>
    					<li><?php echo __('The matrix $A$ has full rank: $rank(A) = n$.'); ?></li>
    				</ul>
    			</p>
    			
    			<p>
    			  <?php echo __('The following table gives an overview of the decompositions covered here:'); ?>
    			</p>
    			
    			<table class="table table-striped table-hover">
    			  <thead>
    			    <tr>
    			      <th><?php echo __('Decomposition'); ?></th>
    			      <th><?php echo __('Factorizazion'); ?></th>
    			      <th><?php echo __('Applicable for'); ?></th>
    			      <th><?php echo __('Runtime'); ?></th>
    			    </tr>
    			  </thead>
    			  <tbody>
    			    <tr>
    			      <td><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/lu'); ?>"><?php echo __('LU'); ?></a></td>
    			      <td><?php echo __('$A = LU$'); ?></td>
    			      <td><?php echo __('$A \in \mathbb{R}^{n \times n}$, $A$ regular'); ?></td>
    			      <td><?php echo __('$\mathcal{O}(\frac{1}{3}n^3)$'); ?></td>
    			    </tr>
    			    <tr>
                <td><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/cholesky'); ?>"><?php echo __('Cholesky'); ?></a></td>
                <td><?php echo __('$A = LDL^T$'); ?></td>
                <td><?php echo __('$A \in \mathbb{R}^{n \times n}$, $A$ symmetric, positive definit'); ?></td>
                <td><?php echo __('$\mathcal{O}(\frac{1}{6}n^3)$'); ?></td>
              </tr>
              <tr>
                <td><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/givens'); ?>"><?php echo __('QR: Givens Rotations'); ?></a></td>
                <td><?php echo __('$A = QR$'); ?></td>
                <td><?php echo __('$A \in \mathbb{R}^{m \times n}$'); ?></td>
                <td><?php echo __('$\mathcal{O}(\frac{4}{3}n^3)$'); ?></td>
              </tr>
              <tr>
                <td><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/householder'); ?>"><?php echo __('QR: Householder Transformations'); ?></a></td>
                <td><?php echo __('$A = QR$'); ?></td>
                <td><?php echo __('$A \in \mathbb{R}^{m \times n}$'); ?></td>
                <td><?php echo __('$\mathcal{O}(\frac{2}{3}n^3)$'); ?></td>
              </tr>
    			  </tbody>
    			</table>
    			
    			<p>
    				<?php echo __('For working with matrices and vectors using PHP the following classes will be used. I know there are already many solutions of data structures for matrices and vectors, and they will most likely be more efficient or more flexible then these, but for demonstrating common used matrix decompositions the given classes will most likely do their jobs.'); ?>
    			</p>
    			
    			<div class="tabbable">
    				<ul class="nav nav-tabs">
    					<li class="active"><a href="#matrix" data-toggle="tab"><?php echo __('Matrix Class'); ?></a></li>
    					<li><a href="#vector" data-toggle="tab"><?php echo __('Vector Class'); ?></a></li>
    				</ul>
    				<div class="tab-content">
    					<div class="tab-pane active" id="matrix">
    						<pre class="prettyprint linenums">
    /**
     * Matrix class.
     *
     * @author  David Stutz
     */
    class Matrix {
        
      /**
       * @var array   data
       */
      private $_data;
      
      /**
       * @var int rows
       */
      private $_rows;
      
      /**
       * @var int columns
       */
      private $_columns;
      
      /**
       * Constructor.
       * 
       * @param int   rows
       * @param int   columns
       * @return  matrix  matrix
       */
      public function __construct($rows, $columns) {
        $this->_data = array();
        
        $rows = (int)$rows;
        Matrix::_assert($rows > 0, 'Invalid number of rows given.');
        
        $columns = (int)$columns;
        Matrix::_assert($columns > 0, 'Invalid number of columns given.');
        
        $this->_rows = (int)$rows;
        $this->_columns = (int)$columns;
      }
      
      /**
       * Resizes the dimensions of the matrix.
       * 
       * @param int   rows
       * @param int   columns
       * @return  matrix  this
       */
      public function resize($rows, $columns) {
        $this->rows = (int)$rows;
        $this->_columns = (int)$columns;
        
        return $this;
      }
      
      /**
       * Compares the matrix with the given matrix for equality.
       * 
       * @param matrix  matrix
       * @return  boolean equals
       */
      public function equals($matrix) {
        Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        Matrix::_assert($this->_rows == $matrix->rows(), 'Matrices do not have same dimensions.');
        Matrix::_assert($this->_columns = $matrix->columns(), 'Matrices do not have same dimensions.');
        
        for ($i = 0; $i < $this->_rows; $i++) {
          for ($j = 0; $j < $this->_columns; $j++) {
            if ($matrix->get($i, $j) != $this->get($i, $j)) {
              return FALSE;
            }
          }
        }
        
        return TRUE;
      }
      
      /**
       * Get number of rows.
       * 
       * @return  int rows
       */
      public function rows() {
        return $this->_rows;
      }
      
      /**
       * Get number of columns.
       * 
       * @return  int columns
       */
      public function columns() {
        return $this->_columns;
      }
      
      /**
       * Get the matrix entry on the position specified by $row and $column.
       * 
       * @param int   row
       * @param int   column
       * @param mixed value
       */
      public function get($row, $column) {
        $row = (int)$row;
        $column = (int)$column;
        
        Matrix::_assert($row >= 0 AND $row < $this->_rows, 'Tried to access invalid row number.');
        Matrix::_assert($column >= 0 AND $column < $this->_columns, 'Tried to access invalid column number.');
        
        $value = 0;
        if (isset($this->_data[$row])) {
          if (isset($this->_data[$row][$column])) {
            $value = $this->_data[$row][$column];
          }
        }
        
        return $value;
      }
      
      /**
       * Set the matrix entry on the position specified by $row and $column.
       * 
       * @param int   row
       * @param int   column
       * @param mixed value
       * @return  matrix  this
       */
      public function set($row, $column, $value) {
        $row = (int)$row;
        $column = (int)$column;
        
        Matrix::_assert($row >= 0 AND $row < $this->_rows, 'Tried to access invalid row number.');
        Matrix::_assert($column >= 0 AND $column < $this->_columns, 'Tried to access invalid column number.');
        
        if (!isset($this->_data[$row])) {
          $this->_data[$row] = array();
        }
        
        $this->_data[$row][$column] = $value;
        
        return $this;
      }
      
      /**
       * Sets all entries of the matrix to the given value.
       * 
       * @param mixed value
       * @return  matrix  this
       */
      public function setAll($value) {
        for ($i = 0; $i < $this->_rows; $i++) {
          for ($j = 0; $j < $this->_columns; $j++) {
            $this->set($i, $j, $value);
          }
        }
      }
      
      /**
       * Copy this matrix.
       * 
       * @return  matrix  copy
       */
      public function copy() {
        $matrix = new Matrix($this->rows(), $this->columns());
        
        for ($i = 0; $i < $this->_rows; $i++) {
          for ($j = 0; $j < $this->_columns; $j++) {
            $matrix->set($i, $j, $this->get($i, $j));
          }
        }
        
        return $matrix;
      }
      
      /**
       * Return the i-th column as vector.
       * 
       * @return vector i-th column
       */
      public function asVector($column) {
        $column = (int)$column;
        
        Matrix::_assert($column >= 0 AND $column < $this->_columns, 'Tried to access invalid column number.');
        
        $vector = new Matrix($this->rows(), $this->columns());
        
        for ($i = 0; $i < $this->_rows; $i++) {
          $vector->set($i, $this->get($i, $column));
        }
        
        return $vector;
      }
      
      /**
       * Get the matrix as array.
       * 
       * @return  array   matrix
       */
      public function asArray() {
        $array = array();
        
        for ($i = 0; $i < $this->rows(); $i++) {
          $array[$i] = array();
          for ($j = 0; $j < $this->columns(); $j++) {
            $array[$i][$j] = $this->get($i, $j);
          }
        }
        
        return $array;
      }
      
      /**
       * Copy content form array.
       * 
       * @param array   data
       * @return  matrix  this
       */
      public function fromArray($array) {
        Matrix::_assert(is_array($array), 'No array given.');
        
        for ($i = 0; $i < $this->rows(); $i++) {
          for ($j = 0; $j < $this->columns(); $j++) {
            if (isset($array[$i][$j])) {
              $this->set($i, $j, $array[$i][$j]);
            }
          }
        }
        
        return $this;
      }
      
      /**
       * Swap the given columns.
       * 
       * @param int column
       * @param   int column
       * @return  matrix  this
       */
      public function swapColumns($i, $j) {
        Matrix::_assert($i >= 0 AND $i < $this->rows(), 'Tried to access invalid column number.');
        Matrix::_assert($j >= 0 AND $j < $this->rows(), 'Tried to access invalid column number.');
        
        for ($k = 0; $k < $this->columns(); $k++) {
          $tmp = $this->get($i, $k);
          $this->set($i, $k, $this->get($j, $k));
          $this->set($j, $k, $tmp);
        }
        
        return $this;
      }
      
      /**
       * Add to matrices.
       * 
       * @param matrix  $a
       * @param matrix  $b
       * @return  matrix  $a + $b
       */
      public static function add($a, $b) {
        Matrix::_assert($a instanceof Matrix, 'Given first matrix not of class Matrix.');
        Matrix::_assert($b instanceof Matrix, 'Given second matrix not of class Matrix.');
        Matrix::_assert($a->rows() == $b->rows(), 'Given matrices do not have same dimensions.');
        Matrix::_assert($a->columns() == $b->columns(), 'Given matrices do not have same dimensions.');
        
        $rows = $a->rows();
        $columns = $a->columns();
        
        $matrix = $a.copy();
        
        for ($i = 0; $i < $rows; $i++) {
          for ($j = 0; $j < $columns; $j++) {
            $matrix->set($i, $j, $matrix->get($i, $j) + $b->get($i, $j));
          }
        }
        
        return $matrix;
      }
      
      /**
       * Transpose the given matrix.
       * 
       * @param matrix  $a
       * @return  matrix  $a transposed
       */
      public static function transpose($a) {
        Matrix::_assert($a instanceof Matrix, 'Given matrix is not of class Matrix.');
        
        $transposed = $a->copy();
        
        for ($i = 0; $i < $a->rows(); $i++) {
          for ($j = 0; $j < $a->columns(); $j++) {
            $transposed->set($j, $i, $a->get($i, $j));
          }
        }
        
        return $transposed;
      }
      
      /**
       * Multiply the given matrices.
       * 
       * @param matrix  $a
       * @param matrix  $b
       * @return  matrix $a*$b
       */
      public static function multiply($a, $b) {
        // First check dimensions.
        Matrix::_assert($a instanceof Matrix, 'Given first matrix not of class Matrix.');
        Matrix::_assert($b instanceof Matrix, 'Given second matrix not of class Matrix.');
        Matrix::_assert($a->rows() == $b->rows(), 'Given dimensions are not compatible.');
        Matrix::_assert($a->columns() == $b->columns(), 'Given dimensions are not compatible.');
        
        $c = new Matrix($a->rows(), $b->columns());
        $c->setAll(0.);
        
        for ($i = 0; $i < $a->rows(); $i++) {
          for ($j = 0; $j < $a->columns(); $j++) {
            for ($k = 0; $k < $b->rows(); $k++) {
              $c->set($i, $j, $c->get($i, $j) + $a->get($i, $k)*$b->get($k, $j));
            }
          }
        }
        
        return $c;
      }
      
      /**
       * Generate LU decomposition of the matrix.
       * 
       * @param matrix  matrix to get the lu decomposition of
       * @return  vector  permutation
       */
      public static function luDecomposition(&$matrix) {
        Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        Matrix::_assert($matrix->rows() == $matrix->columns(), 'Matrix is no quadratic.');
        
        $permutation = new Vector($matrix->rows());
        
        for ($j = 0; $j < $matrix->rows(); $j++) {
          
          $pivot = $j;
          for ($i = $j + 1; $i < $matrix->rows(); $i++) {
            if (abs($matrix->get($i,$j)) > abs($matrix->get($pivot, $j))) {
              $pivot = $i;
            }
          }
          
          $permutation->set($j, $pivot);
          
          $matrix->swapColumns($j, $pivot);
          
          for ($i = $j + 1; $i < $matrix->columns(); $i++) {
            $matrix->set($i, $j, $matrix->get($i, $j)/$matrix->get($j, $j));
            
            for ($k = $j + 1; $k < $matrix->columns(); $k++) {
              $matrix->set($i, $k, $matrix->get($i, $k) - $matrix->get($i, $j)*$matrix->get($j,$k));
            }
          }
        }
        
        return $permutation;
      }
      
      /**
       * Generate LU decomposition of the matrix.
       * 
       * @param matrix  matrix to get lu decomposition of
       * @param array   store the trace in here
       * @return  vector  permutation
       */
      public static function luDecompositionWithTrace(&$matrix, &$trace) {
        Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        Matrix::_assert($matrix->rows() == $matrix->columns(), 'Matrix is not quadratic.');
        
        $permutation = new Vector($matrix->rows());
        
        for ($j = 0; $j < $matrix->rows(); $j++) {
          
          $pivot = $j;
          for ($i = $j + 1; $i < $matrix->rows(); $i++) {
            if (abs($matrix->get($i,$j)) > abs($matrix->get($pivot, $j))) {
              $pivot = $i;
            }
          }
          
          $permutation->set($j, $pivot);
          
          $matrix->swapColumns($j, $pivot);
          
          // Save the matrix after permutation.
          $trace[$j] = array(
            'permutation' => $matrix->copy(),
          );
          
          for ($i = $j + 1; $i < $matrix->columns(); $i++) {
            $matrix->set($i, $j, $matrix->get($i, $j)/$matrix->get($j, $j));
            
            for ($k = $j + 1; $k < $matrix->columns(); $k++) {
              $matrix->set($i, $k, $matrix->get($i, $k) - $matrix->get($i, $j)*$matrix->get($j,$k));
            }
          }
          
          // Save the matrix after elimination.
          $trace[$j]['elimination'] = $matrix->copy();
        }
        
        return $permutation;
      }
      
      /**
       * Solve system of linear equation using a right hand vector, the lu decomposition and the permutation vector of the lu decomposition.
       * 
       * @param matrix  lu decomposition
       * @param vector  permutation vector of lu decomposition
       * @param vector  right hand
       */
      public static function luSolve($matrix, $permutation, $rightHand) {
        Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        Matrix::_assert($permutation instanceof Vector, 'Given permutation vector not of class Vector.');
        Matrix::_assert($b instanceof Vector, 'Given right hand not of class Vector.');
        Matrix::_assert($matrix->rows() == $matrix->columns(), 'Matrix is not quadratic.');
        Matrix::_assert($matrix->rows() == $permutation->size(), 'Permutation vector does not have correct size.');
        Matrix::_assert($matrix->rows() == $rightHand->size(), 'Right hand vector does not have correct size.');
        
        $b = $rightHand.copy();
        
        for ($i = 0; $i < $b->size(); $i++) {
          $b->swapColumns($i, $permutation->get($i));
        }
        
        // First solve L*y = b.
        for ($i = 0; $i < $matrix->rows(); $i++) {
          for ($j = $i - 1; $j >= 0; $j--) {
            $b->set($i, $b->get($i) - $b->get($j)*$matrix->get($i, $j));
          }
        }
        
        // Now solve R*x =y.
        for ($i = $matrix->rows() - 1; $i >= 0; $i--) {
          for ($j = $i + 1; $j < $matrix->columns(); $j--) {
            $b->set($i, $b->get($i) - $b->get($j)*$matrix->get($i, $j));
          }
          $b->set($i, $b->get($i)/$matrix->get($i, $i));
        }
        
        return $b;
      }
      
      /**
       * Calculate the determinant of the matrix with the given lu decomposition.
       * 
       * @param matrix  lu decomposition
       * @param vector  permutation vector of the lu decomposition
       */
      public static function luDeterminant($matrix, $permutation) {
        Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        Matrix::_assert($permutation instanceof Vector, 'Permutation vector not of class Vector.');
        Matrix::_assert($matrix->rows() == $matrix->columns(), 'Matrix is not quadratic.');
        Matrix::_assert($matrix->rows() == $permutation->size(), 'Permutation vetor does not have correct size.');
        
        // Calculate number of swapped rows.
        $swapped = 0;
        for ($i = 0; $i < $permutation->size(); $i++) {
          if ($permutation->get($i) != $i) {
            $swapped++;
          }
        }
        
        $determinant = pow(-1,$swapped);
        
        for ($i = 0; $i < $matrix->rows(); $i++) {
          $determinant *= $matrix->get($i, $i);
        }
        
        return $determinant;
      }
      
      /**
       * Get the qr decomposition of the given matrix using givens rotations.
       * 
       * @param matrix  matrix to get the qr decomposition of
       */
      public static function qrDecompositionGivens(&$matrix) {
        Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        
        for ($j = 0; $j < $matrix->columns(); $j++) {
          for ($i = $j + 1; $i < $matrix->rows(); $i++) {
            // If the entry is zero it can be skipped.
            if ($matrix->get($i, $j) != 0) {
              $r = sqrt(pow($matrix->get($j, $j), 2) + pow($matrix->get($i, $j), 2));
              
              if ($matrix->get($i, $j) < 0) {
                $r = -$r;
              }
              
              $s = $matrix->get($i, $j)/$r;
              $c = $matrix->get($j, $j)/$r;
              
              // Apply the givens rotation:
              for ($k = $j; $k < $matrix->columns(); $k++) {
                $jk = $matrix->get($j ,$k);
                $ik = $matrix->get($i, $k);
                $matrix->set($j, $k, $c*$jk + $s*$ik);
                $matrix->set($i, $k, -$s*$jk + $c*$ik);
              }
              
              // c and s can be stored in one matrix entry:
              if ($c == 0) {
                $matrix->set($i, $j, 1);
              }
              else if (abs($s) < abs($c)) {
                if ($c < 0) {
                  $matrix->set($i, $j, -.5*$s);
                }
                else {
                  $matrix->set($i, $j, .5*$s);
                }
              }
              else {
                $matrix->set($i, $j, 2./$c);
              }
            }
          }
        }
      }
      
      /**
       * Get the qr decomposition of the given matrix using givens rotations.
       * 
       * @param matrix  matrix to get the qr decomposition of
       * @param array   store the trace in here
       */
      public static function qrDecompositionGivensWithTrace(&$matrix, &$trace) {
        Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        
        for ($j = 0; $j < $matrix->columns(); $j++) {
          $trace[$j] = array();
          for ($i = $j + 1; $i < $matrix->rows(); $i++) {
            // If the entry is zero it can be skipped.
            if ($matrix->get($i, $j) != 0) {
              $r = sqrt(pow($matrix->get($j, $j), 2) + pow($matrix->get($i, $j), 2));
            
              if ($matrix->get($i, $j) < 0) {
                $r = -$r;
              }
              
              $s = $matrix->get($i, $j)/$r;
              $c = $matrix->get($j, $j)/$r;
              
              // Apply the givens rotation.
              for ($k = $j; $k < $matrix->columns(); $k++) {
                $jk = $matrix->get($j ,$k);
                $ik = $matrix->get($i, $k);
                $matrix->set($j, $k, $c*$jk + $s*$ik);
                $matrix->set($i, $k, -$s*$jk + $c*$ik);
              }
              
              // This time roh (so c and s) are not stored within the matrix but given using the trace.
              
              $trace[$j][$i] = array(
                'c' => $c,
                's' => $s,
                'matrix' => $matrix->copy(), // Has to be a copy not a reference!
              );
            }
          }
        }
      }
      
      /**
       * Get the cholesky decomposition of the given matrix.
       * 
       * @param matrix  matrix to get the cholesky decomposition of
       */
      public static function choleskyDecomposition(&$matrix, double $tolerance = NULL) {
        Matrix::_assert($matrix instanceof Matrix, 'Given matrix not of class Matrix.');
        
        if ($tolerance === NULL) {
          $tolerance = (double)0.00001;
        }
        
        for ($j = 0; $j < $matrix->columns(); $j++) {
        $d = $matrix->get($j, $j);
        for ($k = 0; $k < $j; $k++) {
          $d -= pow($matrix->get($j, $k), 2)*$matrix->get($k, $k);
        }
        
        // Test if symmetric, positive definit can be guaranteed.
        Matrix::_assert($d > $tolerance*(double)$matrix->get($j, $j), 'Symmetric, positive definit can not be guaranteed: ' . $d . ' > ' . $tolerance*(double)$matrix->get($j, $j));
        
        $matrix->set($j, $j, $d);
        
        for ($i = $j + 1; $i < $matrix->rows(); $i++) {
          $matrix->set($i, $j, $matrix->get($i, $j));
          for ($k = 0; $k < $j; $k++) {
            $matrix->set($i, $j, $matrix->get($i, $j) - $matrix->get($i, $k)*$matrix->get($k, $k)*$matrix->get($j, $k));
          }
          $matrix->set($i, $j, $matrix->get($i, $j)/((double)$matrix->get($j, $j)));
        }
      }
      
      /**
       * Asserts the given expression.
       * 
       * @throws  Exception
       */
      private static function _assert($boolean, $message = '') {
        if (!$boolean) {
          throw new \Exception($message);
        }
      }
    }
    						</pre>
    					</div>
    					<div class="tab-pane" id="vector">
    						<pre class="prettyprint linenums">
    /**
     * Vector class.
     *
     * @author  David Stutz
     */
    class Vector {
        
      /**
       * @var array   data
       */
      private $_data;
      
      /**
       * @var int size
       */
      private $_size;
      
      /**
       * Constructor.
       * 
       * @param int   size
       * @return  vector  vector
       */
      public function __construct($size) {
        $this->_data = array();
        
        $size = (int)$size;
        Vector::_assert($size > 0, 'Invalid size given.');
        
        $this->_size = (int)$size;
      }
      
      /**
       * Resizes the dimensions of the matrix.
       * 
       * @param int   rows
       * @param int   columns
       * @return  matrix  this
       */
      public function resize($rows) {
        $this->rows = (int)$rows;
        
        return $this;
      }
      
      /**
       * Compares the matrix with the given matrix for equality.
       * 
       * @param matrix  matrix
       * @return  boolean equals
       */
      public function equals($vector) {
        Vector::_assert($vector instanceof Vector, 'Given vector not of class Vector.');
        Vector::_assert($this->_rows == $vector->size(), 'The dimensions do not match.');
        
        for ($i = 0; $i < $this->_rows; $i++) {
          for ($j = 0; $j < $this->_columns; $j++) {
            if ($matrix->get($i, $j) != $this->get($i, $j)) {
              return FALSE;
            }
          }
        }
        
        return TRUE;
      }
      
      /**
       * Get number of rows.
       * 
       * @return  int rows
       */
      public function size() {
        return $this->_size;
      }
      
      /**
       * Get the matrix entry on the position specified by $position.
       * 
       * @param int   position
       * @param mixed value
       */
      public function get($position) {
        $position = (int)$position;
        
        Vector::_assert($position >= 0 AND $position < $this->_size, 'Tried to access invalid position.');
        
        $value = 0;
        if (isset($this->_data[$position])) {
          $value = $this->_data[$position];
        }
        
        return $value;
      }
      
      /**
       * Set the vector entry on the specified $position.
       * 
       * @param int   position
       * @param mixed value
       * @return  matrix  this
       */
      public function set($position, $value) {
        $position = (int)$position;
        
        Vector::_assert($position >= 0 AND $position < $this->_size, 'Tried to access invalid position.');
        
        $this->_data[$position]= $value;
        
        return $this;
      }
      
      /**
       * Sets all entries of the matrix to the given value.
       * 
       * @param mixed value
       * @return  matrix  this
       */
      public function setAll($value) {
        for ($i = 0; $i < $this->_size; $i++) {
          $this->set($i, $value);
        }
      }
      
      /**
       * Copy this matrix.
       * 
       * @return  matrix  copy
       */
      public function copy() {
        $vector = new Vector($this->size());
        
        for ($i = 0; $i < $this->_rows; $i++) {
          $vector->set($i, $this->get($i));
        }
        
        return $vector;
      }
      
      /**
       * Swap the given columns.
       * 
       * @param int column
       * @param   int column
       * @return  matrix  this
       */
      public function swapEntries($i, $j) {
        Vector::_assert($i >= 0 AND $i < $this->size(), 'Tried to access invalid position.');
        Vector::_assert($j >= 0 AND $j < $this->size(), 'Tried to access invalid position.');
        
        $tmp = $this->get($i);
        $this->set($i, $this->get($j));
        $this->set($j, $tmp);
        
        return $this;
      }
      
      /**
       * Build the inner product of two vectors.
       * 
       * @param vector  $a
       * @param vector  $b
       * @return  vector  inner product
       */
      public static function innerProduct($a, $b) {
        Vector::_assert($a instanceof Vector, 'Given first vector not of class Vector.');
        Vector::_assert($b instanceof Vector, 'Given second vector not of class Vector.');
        Vector::_assert($a->size() == $b->size(), 'Dimensions do not match.');
        
        $size = $a->size();
        $result = 0;
        
        for ($i = 0; $i < $size; $i++) {
          $result += $a->get($i)*$b->get($i);
        }
        
        return $result;
      }
      
      /**
       * Asserts the given expression.
       * 
       * @throws  Exception
       */
      private static function _assert($boolean, $message = '') {
        if (!$boolean) {
          throw new \Exception($message);
        }
      }
    }
    						</pre>
    					</div>
    				</div>
    			</div>
    		</div>
			</div>
			<hr>
			<p>
				David Stutz - <a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a>
			</p>
		</div>
	</body>
</html>
</html>