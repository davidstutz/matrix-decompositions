<!DOCTYPE html>
<html>
	<head>
		<title><?php echo __('Matrix Decompositions - QR Decomposition - Givens Rotations'); ?></title>
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
            <li>
              <a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions'); ?>"><?php echo __('Matrix Decompositions'); ?></a>
              <ul class="nav nav-pills nav-stacked" style="margin-left: 20px;">
                <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/lu'); ?>"><?php echo __('LU Decomposition'); ?></a></li>
                <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/cholesky'); ?>"><?php echo __('Cholesky Decomposition'); ?></a></li>
                <li class="active"><a href="#"><?php echo __('QR Decomposition'); ?></a></li>
              </ul>
            <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('applications'); ?>"><?php echo __('Applications'); ?></a></li>
            <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('credits'); ?>"><?php echo __('Credits'); ?></a></li>
          </ul>
	      </div>
	      <div class="span9">
  		    <p>
  		    	<?php echo __('The QR decomposition is a factorization $A = QR$ of a matrix $A \in \mathbb{R}^{m \times n}$ in an orthogonal Matrix $Q \in \mathbb{R}^{m \times m}$ and an upper triangular matrix $R \in \mathbb{R}^{m \times n}$.'); ?>
  		    </p>
  		    
  		    <p>
  		      <?php echo __('Some basic characteristics of orthogonal matrices. Let $Q \in \mathbb{R}^{n \times n}$ be an orthogonal matrix.'); ?>
  		      <ul>
  		        <li><?php echo __('$Q^T$ is orthogonal.'); ?></li>
  		        <li><?php echo __('Let $\bar{Q} \in \mathbb{R}^{n \times n}$ be orthogonal, then $Q \cdot \bar{Q}$ is orthogonal.'); ?></li>
  		        <li><?php echo __('The columns of $Q$ form an orthonormal basis of $\mathbb{R}^n$.'); ?></li>
  		      </ul>
  		    </p>
  		    
  		    <p>
  		      <b><?php echo __('Applications.'); ?></b>
  		      <ul>
  		        <li><?php echo __('The problem $Ax = b$ is reduced to solving $Rx = Q^{-1}b = Q^Tb$.'); ?></li>
  		        <li><?php echo __('The QR decompositions is widely used to solve the linear least squares problem as well as the nonlinear least squares problem.'); ?></li>
  		        <li><?php echo __('The so called "QR algorithm" uses QR decompositions to compute the eigenvalues of a matrix.'); ?></li>
  		      </ul>
  		    </p>
  		    
  		    <p>
  		    	<?php echo __('Among others there are two popular methods to compute a QR decompositions:'); ?>
  		    </p>
  		    
  		    <ul class="nav nav-pills">
  			    <li class="active"><a href="#"><?php echo __('Givens rotations'); ?></a></li>
  			    <li><a href="/matrix-decompositions<?php echo $app->router()->urlFor('matrix-decompositions/householder'); ?>"><?php echo __('Householder transformations'); ?></a></li>
  		    </ul>
  		    
  		    <div class="tabbable">
    				<ul class="nav nav-tabs">
    					<li><a href="#code" data-toggle="tab"><?php echo __('Code'); ?></a></li>
    					<li><a href="#algorithm" data-toggle="tab"><?php echo __('Algorithm'); ?></a></li>
    					<li <?php if (!isset($original)): ?>class="active"<?php endif; ?>><a href="#demo" data-toggle="tab"><?php echo __('Demo'); ?></a></li>
    					<?php if (isset($original)): ?>
    						<li class="active"><a href="#result" data-toggle="tab"><?php echo __('Result'); ?></a></li>
    					<?php endif; ?>
    				</ul>
            <div class="tab-content">
    					<div class="tab-pane" id="code">
    						<pre class="prettyprint linenums">
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
    						</pre>
    					</div>
    					<div class="tab-pane" id="algorithm">
    						<p>
    						  <?php echo __('The algorithm is based on the so called givens rotations (named after <a target="_blank" href="http://en.wikipedia.org/wiki/Wallace_Givens">Wallace Givens</a>), which are orthogonal. Using a sequence of givens rotations the given matrix can be transformed to an upper triangular matrix.'); ?>
    						</p>
    						
    						<!--
    						<p>
    						  <?php echo __('Consider the following problem: Find $c$ and $s$ such that:'); ?>
    						</p>
    						
    						<p>
    						  $\left[\begin{array}{c c} 
                    c & -s \\
                    s & c \\
                  \end{array} \right]
                  \left[\begin{array}{c} 
                    a \\
                    b \\
                  \end{array} \right]
                   = 
                  \left[\begin{array}{c} 
                    r \\
                    0 \\
                  \end{array} \right]$
                </p>
                
                <p>
                  <?php echo __('Under the condition that $c^2 + s^2 = 1$.'); ?>
                  
                  <?php echo __('Then'); ?> 
                  $\left[\begin{array}{c c}
                    c & -s \\ s & c \\
                  \end{array} \right]$ 
                  <?php echo __('will be orthogonal'); ?>
                   - 
                  $\left[\begin{array}{c}
                    c \\
                    -s \\
                  \end{array} \right]$ 
                  <?php echo __('and'); ?> 
                  $\left[\begin{array}{c}
                    s \\
                    c \\
                  \end{array} \right]$
                  <?php echo __('form an orthonormal basis if $\mathbb{R}^n$.'); ?>
                </p>
                
                <p>
                  <?php echo __('The solution is given by $r = \sqrt{a^2 + b^2}$, $c = \frac{a}{r}$ and $s = \frac{b}{r}$. By embedding the givens rotation into the identity matrix we have found a way to eliminate the $i$-th entry of a vector (or column of a matrix) $x \in \mathbb{R}^n:'); ?>
                </p>
                -->
                
                <p>
                  <?php echo __('Using givens rotations we can eliminate a single entry of a vector (or column) $x \in \mathbb{R}^n$:'); ?>
                </p>
                
                <p>
                  $G = 
                  \left[\begin{array}{c c c c c c c} 
                    1 & & & & \ldots & & & & 0\\
                     & \ddots & & & & & & & \\
                     & & & c & \ldots & -s & & & \\
                    \vdots & & & \vdots & & \vdots & & & \vdots \\
                     & & & s & \ldots & c & & & \\
                     & & & & & & & \ddots & \\
                    0 & & & & \ldots & & & & 1 \\
                  \end{array} \right]
                  \left[\begin{array}{c} 
                    x_1 \\
                    \vdots \\
                    x_i \\
                    \vdots \\
                    x_j \\
                    \vdots \\
                    x_n \\
                  \end{array} \right]
                   = 
                  \left[\begin{array}{c} 
                    x_1 \\
                    \vdots \\
                    r \\
                    \vdots \\
                    0\ \\
                    \vdots \\
                    x_n \\
                  \end{array} \right]
                  $
                </p>
                
                <p>
                  <?php echo __('Where $r = \sqrt{x_i^2 + x_j^2}$ and $c$ and $s$ can be computed using: $c = \frac{x_i}{r}$, $s = \frac{x_j}{r}$.'); ?>
                </p>
                
                <p>
                  <?php echo __('$G$ is obviously orthogonal - the columns form an orthonormal basis of $\mathbb{R}^n$. In addition note that $G$ is only affecting the $i$-th and $j$-th row when applied on a matrix.') ;?>
                </p>
                
                <p>
                  <?php echo __('So the matrix $A$ can be reduced to an upper triangular matrix by eliminating all entries below the diagonal:'); ?>
                </p>
                
                <p>
                  $G_{m,n-1} \ldots G_{3,1} G_{2,1} G_{1,1} A = R$
                </p>
                
                <p>
                  <?php echo __('Where $G_{i,j}$ is the givens rotation eliminating the $i$-th entry in the $j$-th column of $A$. So the decomposition is given by:'); ?>
                </p>
                
                <p>
                  $A = G_{1,1}^T G_{2,1}^T G_{3,1}^T \ldots G_{m,n}^T R = QR$
                </p>
                
                <p>
                  <?php echo __('The algorithm goes simply through all entries below the diagonal and checks if they need to be eliminated. If so the appropriate givens rotation will be computed and applied on the matrix. Note that computing $c$ and $s$ is sufficient for applying the rotation.'); ?>
                </p>
                
                <p>
                  <b><?php echo __('Algorithm.'); ?></b>
                  <ul style="list-style-type:none;">
                    <li><?php echo __('For $i = 1, \ldots, n - 1$:'); ?>
                      <ul style="list-style-type:none;">
                        <li><?php echo __('For $i = j + 1, \ldots, m$:'); ?>
                          <ul style="list-style-type:none;">
                            <li><?php echo __('If $a_{i, j} \neq 0$:'); ?>
                              <ul style="list-style-type:none;">
                                <li><?php echo __('Set up $G_{i, j}$ by computing $r := \sqrt{a_{j, j}^2 + x_{i,j}^2}$, $c := \frac{a_{j, j}}{r}$, $s := \frac{x_{i, j}}{r}$'); ?></li>
                                <li><?php echo __('Apply $G_{i, j}$ on $A$.'); ?></li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </p>
                
                <p><?php echo __('In addition $G_{i, j}$ can be saved in $a_{i, j}$ the following way:'); ?></p>
                
                <p>
                  <ul style="list-style-type:none;">
                    <li><?php echo __('If $c = 0$:'); ?>
                      <ul style="list-style-type:none;">
                        <li><?php echo __('$a_{i, j} := 0$'); ?></li>
                      </ul>
                    </li>
                    <li><?php echo __('If $|s| < |c|$:'); ?>
                      <ul style="list-style-type:none;">
                        <li><?php echo __('$a_{i, j} := \frac{1}{2}sign(c)s$'); ?></li>
                      </ul>
                    </li>
                    <li><?php echo __('If $|c| \leq |s|$:'); ?>
                      <ul style="list-style-type:none;">
                        <li><?php echo __('$a_{i, j} := 2\frac{sign(s)}{c}$'); ?></li>
                      </ul>
                    </li>
                  </ul>
                </p>
                
    					</div>
    					<div class="tab-pane <?php if (!isset($original)): ?>active<?php endif; ?>" id="demo">
    						<form class="form-horizontal" method="POST" action="/<?php echo $app->config('base') . $app->router()->urlFor('matrix-decompositions/givens/demo'); ?>">
    							<div class="control-group">
    								<label class="control-label"><?php echo __('Matrix'); ?></label>
    								<div class="controls">
    									<textarea name="matrix" rows="10" class="span6"></textarea>
    								</div>
    							</div>
    							<div class="form-actions">
    								<button class="btn btn-primary type="submit"><?php echo __('Calculate QR Decomposition'); ?></button>
    							</div>
    						</form>
    					</div>
              <?php if (isset($original)): ?>
      					<div class="tab-pane active" id="result">
    							<p><b><?php echo __('Given matrix.'); ?></b></p>
    							
    							<p><?php echo $app->render('Matrix.php', array('matrix' => $original)); ?> $\in \mathbb{R}^{<?php echo $original->rows(); ?> \times <?php echo $original->columns(); ?>}$</p>
    							
    							<p><b><?php echo __('Algorithm.'); ?></b></p>
    							
    							<?php $givens = new \Libraries\Matrix(max($original->columns(), $original->rows()), max($original->columns(), $original->rows())); ?>
    							<?php foreach ($trace as $j => $column): ?>
    							  <?php foreach ($column as $i => $array): ?>
    							    <?php // Get the givens rotation of this step.
    							    $givens->setAll(0);
                      for ($k = 0; $k < $givens->rows(); $k++) {
                        $givens->set($k, $k, 1.);
                      }
                      
                      $givens->set($j, $j, $array['c']);
                      $givens->set($j, $i, $array['s']);
                      $givens->set($i, $i, $array['c']);
                      $givens->set($i, $j, - $array['s']);
                      
                      $q = \Libraries\Matrix::multiply($q, \Libraries\Matrix::transpose($givens));
                      ?>
      								<p>
      									$\overset{G_{<?php echo $i + 1; ?>,<?php echo $j + 1; ?>}}{\leadsto}$ <?php echo $app->render('Matrix.php', array('matrix' => $array['matrix'])); ?> <?php echo __('with'); ?> $G_{<?php echo $i + 1; ?>,<?php echo $j + 1; ?>} = $ <?php echo $app->render('Matrix.php', array('matrix' => $givens)); ?>
      								</p>
      							<?php endforeach; ?>
    							<?php endforeach; ?>
    							
    							<p><b><?php echo __('Decomposition.'); ?></b></p>
    							
    							<p>
    							  $R = $ <?php echo $app->render('Matrix.php', array('matrix' => $r)); ?>
    							</p>
    							
    							<p>
    							  $Q = <?php foreach ($trace as $j => $column): ?>
                      <?php foreach ($column as $i => $array): ?>
                        G_{<?php echo $i + 1; ?>,<?php echo $j + 1; ?>} ^{T}
                        <?php endforeach; ?>
                      <?php endforeach; ?>
                     = $ <?php echo $app->render('Matrix.php', array('matrix' => $q)); ?>
    							</p>
    					 </div>
              <?php endif; ?>
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