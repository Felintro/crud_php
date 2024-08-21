<?php
	$resultado = '';
	foreach ($vagas as $vaga) {
		$resultado .= 
			'<tr>
				<td>'.$vaga->id.'</td>
				<td>'.$vaga->titulo.'</td>
				<td>'.$vaga->descricao.'</td>
				<td>'.($vaga->ativo == 's' ? 'Ativo' : 'Inativo').'</td>
				<td>'.date('d/m/Y \a\s H:i:s', strtotime($vaga->dt_abertura)).'</td>
				<td>
					<a href="editar.php?id='.$vaga->id.'">
						<button type="button" class="btn btn-primary">Editar</button>
					</a>
					<a href="excluir.php?id='.$vaga->id.'">
						<button type="button" class="btn btn-danger">Excluir</button>
					</a>
				</td>
			</tr>';
	}
?>

<main>
	<section>
		<a href="cadastrar.php">
			<button class="btn btn-success">Nova vaga</button>
		</a>
	</section>

	<section>
		<table class="table bg-light mt-3">
			<thead>
				<tr>
					<th>#</th>
					<th>Título</th>
					<th>Descrição</th>
					<th>Status</th>
					<th>Data de abertura</th>
					<th>Ações</th>
				</tr>
			</thead>

			<tbody>
				<?= $resultado ?>
			</tbody>

		</table>
	</section>
</main>