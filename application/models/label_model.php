<?php
class Label_model extends CI_Model
{
    function findLabelWithId($id)
    {
        $db = $this->load->database('default', TRUE);
        
        $sql = "SELECT * FROM cola_label WHERE id = ?";
        $query = $db->query($sql, array($id));
        $db->close();
        
        if ($query->num_rows() === 0)
        {
            $this->responseError(404, 'label not found');
            return FALSE;
        }
        
        return $query->row_array();
    }
}
