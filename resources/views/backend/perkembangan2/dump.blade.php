
		$drops  = [];
		$index = 1; 
		foreach ($papapa as $key => $value) {
			$index2 = 1;
			$drops[$index]['label'] = $key;
			$drops[$index]['color'] = $key;
			foreach ($value as $k => $v) {
				$drops[$index]['data'][$index2++] = $v['summary'];
				$drops[$index]['data'][$index2++] = $v['summary'];
			}
			$index++;
		}
		$dataset2  = [$drops];
		$dataset = [
					[ 'label' => 'cabang',
					'background' => 'black',
					'data'=> [1,10,20,99,19,20,30,21],
					],
					[ 'label' => 'cabang2',
					'data'=> [0, 10, 5, 2, 20, 30, 45],
					],
					[ 'label' => 'cabang3',
					'data'=> [40,20,21,30,31,20,40],
					],
					[ 'label' => 'cabang3',
					'data'=> [40,20,21,30,31,20,40],
					],
					];
		
		$labels = $labels->keys();
		// $data = json_encode($dataset);	
		// $data = json_encode($dataset2);	
		$data = json_encode($drops);	


		<div class="card">
        <div class="card-header">
          <h3 class="card-title">Projects</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">

        </div>
        <!-- /.card-body -->
      </div>