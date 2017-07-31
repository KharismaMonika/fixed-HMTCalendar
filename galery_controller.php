<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class galery_controller extends CI_Controller {

	function index(){
		#$data['listkepengurusan'] = $this->Model_kepengurusan->list_kepengurusan();
		#$tahun = $this->input->post('id_tahun');
		#$data['listdepartemen'] = $this->Model_departemen->get_id($tahun);
		#$id_departemen = $this->input->post('id_dep');
		$data['departemen'] = $this->Model_kegiatan->getListDepartemen();
		$data['kepengurusan'] = $this->Model_kegiatan->getListKepengurusan();
		#$data['foto'] = $this->Model_foto->get_foto($id_departemen);
		$this->load->view('admin/gallery', $data);
	}

	public function select_foto_departemen(){
		if('IS_AJAX') {
			$data['departemen'] = $this->Model_kegiatan->getListDepartemen();
			$this->load->view('admin/dd_departemen_foto',$data);
		}

	}

	public function view_foto(){
		if('IS_AJAX') {	
		$id_departemen = $this->input->post('id_departemen');
		$data['foto'] = $this->Model_foto->lihat_foto();
		$this->load->view('admin/view_foto', $data);
		}
	}

	public function unggah_foto(){
		#$data['listkepengurusan'] = $this->Model_kepengurusan->list_kepengurusan();
		#$tahun = $this->input->post('id_tahun');
		#$data['listdepartemen'] = $this->Model_departemen->get_id($tahun); //departemen
		$data['kepengurusan'] = $this->Model_kegiatan->getListKepengurusan();
		$this->load->view('admin/unggah_foto', $data);
	}

	public function simpan(){
		// setting konfigurasi upload
        $config['upload_path'] = './foto/';
        $config['allowed_types'] = 'gif|jpg|png|PNG';
        // load library upload
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('nama_file')) 
        {
            $error = $this->upload->display_errors();
            echo "hello ";
            // menampilkan pesan error
            print_r($error);
        } else 
        {
            $result = $this->upload->data();
            $file_name = $result['full_path'];
			$foto = array(
					'id_departemen_fk' => $this->input->post('id_departemen'),		
				 	'nama_foto' => $result['file_name']);
			$this->db->insert('foto', $foto);
        }
        redirect('galery_controller');
	}

	public function delete_foto(){
		$id_foto = $this->uri->segment(3);
		$this->db->where('id_foto',$id_foto );
		$this->db->delete('foto');
		redirect('galery_controller');
	}

	public function edit_foto(){
		$id_foto = $this->uri->segment(3);
		$this->load->view('admin/edit_foto');
	}

	public function simpan_edit(){
		$id_foto =$this->input->post('id_foto');
		#$id_foto = $this->uri->segment(3);
		#echo $id_foto;
		$config['upload_path'] = './foto/';
        $config['allowed_types'] = 'gif|jpg|png|PNG';
        // load library upload
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('nama_file')) 
        {
            $error = $this->upload->display_errors();
            echo "hello ";
            // menampilkan pesan error
            print_r($error);
        } 
        else 
        {
            $result = $this->upload->data();
            $file_name = $result['full_path'];
			$foto = array(		
				 	'nama_foto' => $result['file_name']);

			$this->db->where('id_foto', $id_foto);
			$this->db->update('foto', $foto);
        }
        redirect('galery_controller');
	}


		
}
