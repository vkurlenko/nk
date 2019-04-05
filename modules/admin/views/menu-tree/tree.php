<?php
use yii\web\JsExpression;

$this->title = 'Дерево';

//debug($data);

?>

<div class="">
	<div class="row">
		<div>
			<div class="box box-primary">
				<div class="box-header with-border">
					<div class="box-tools pull-right">
						<a href="<?=\yii\helpers\Url::toRoute('menu-tree/create')?>" class="btntn-box-tool"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>
					</div>
				</div>
				
				<div class="box-body">
					<?php
					
						echo \wbraganca\fancytree\FancytreeWidget::widget([
							'options' =>[
								'source' => $data,
								'extensions' => ['dnd'],
								'dnd' => [
									'preventVoidMoves' => true,
									'preventRecursiveMoves' => true,
									'autoExpandMS' => 400,
									'dragStart' => new JsExpression('function(node, data) {
										return true;
									}'),
									'dragEnter' => new JsExpression('function(node, data) {
										return true;
									}'),
									'dragDrop' => new JsExpression('function(node, data) {
										$.get("move", {
												item: data.otherNode.key.substr(1), 
												action: data.hitMode, 
												second: node.key.substr(1)
											},											
											
											function(){
												data.otherNode.moveTo(node, data.hitMode);
												console.log(data.hitMode);
											});
											
											//data.otherNode.moveTo(node, data.hitMode);
									}'),
								],
								
								'activate' => new JsExpression('function(event, data){
									console.log(data);
									var title = data.node.title;
									var id = data.node.key.substr(1);
									$("#cat-info .box-header>h3").text(title);
								}')
							]
						]);
					?>
				</div>
			</div>
		</div>
	</div>
</div>