<?php
//Message Set
include_once'var-message.php';

class Article{
	public function newArticle($dbHandle,$category_id,$user_id,$title,$keyword,$image,$text,$credit,$type,$status){

		global $msg;
		$stmt = $dbHandle->prepare('SELECT ar_id FROM bl_article WHERE ar_image = ?');
    	$stmt->execute(array($image));
		$var = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($var['ar_id'] == ""){

			$description = strip_tags($text);

			try{
				$stmt = $dbHandle->prepare('INSERT INTO bl_article(ar_category_id,ar_user_id,ar_title,ar_description,ar_keyword,ar_image,ar_text,ar_credit,ar_post_time,ar_update_time,ar_type,ar_status) VALUES(:category,:user,:title,:description,:keyword,:image,:context,:credit,:post_time,:update_time,:type,:status)');

				$stmt->bindParam(':category',$category_id);
				$stmt->bindParam(':user',$user_id);
				$stmt->bindParam(':title',$title);
				$stmt->bindParam(':description',$description);
				$stmt->bindParam(':keyword',$keyword);
				$stmt->bindParam(':image',$image);
				$stmt->bindParam(':context',$text);
				$stmt->bindParam(':credit',$credit);
				$stmt->bindParam(':post_time',time()); //Create Time
				$stmt->bindParam(':update_time',time()); //Last time
				$stmt->bindParam(':type',$type);
				$stmt->bindParam(':status',$status);
			
				$stmt->execute();
				
				return $msg['10'];
			}
			catch(PDOException $e){
				return $msg['0'];
			}
		}
		else{
			return $msg['12'];
		}
	}

	public function updateArticle($dbHandle,$article_id,$category_id,$user_id,$title,$keyword,$image,$text,$credit,$type,$status){

		global $msg;
		$stmt = $dbHandle->prepare('SELECT ar_id FROM bl_article WHERE ar_image = ?');
    	$stmt->execute(array($image));
		$var = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if(true){

			$description = strip_tags($text);

			try{
				$stmt = $dbHandle->prepare('UPDATE bl_article SET ar_category_id = :category,ar_user_id = :user,ar_title = :title,ar_description = :description,ar_keyword = :keyword,ar_image = :image,ar_text = :context,ar_credit = :credit,ar_update_time = :update_time,ar_type = :type,ar_status = :status WHERE ar_id = :id');

				//$stmt = $dbHandle->prepare('UPDATE bl_article SET ar_title = :title WHERE ar_id = :id');

				$stmt->bindParam(':category',$category_id);
				$stmt->bindParam(':user',$user_id);
				$stmt->bindParam(':title',$title);
				$stmt->bindParam(':description',$description);
				$stmt->bindParam(':keyword',$keyword);
				$stmt->bindParam(':image',$image);
				$stmt->bindParam(':context',$text);
				$stmt->bindParam(':credit',$credit);
				$stmt->bindParam(':update_time',time()); //Last time
				$stmt->bindParam(':type',$type);
				$stmt->bindParam(':status',$status);
				$stmt->bindParam(':id',$article_id);
			
				$stmt->execute();
				
				return $msg['11'];
			}
			catch(PDOException $e){
				return $msg['0'];
			}
		}
		else{
			return $msg['12'];
		}
	}

	public function statusArticle($dbHandle,$article_id,$status){

		global $msg;
		try{
			$stmt = $dbHandle->prepare('UPDATE bl_article SET ar_status = :status,ar_update_time = :update_time WHERE ar_id = :id');

				$stmt->bindParam(':update_time',time()); //Last time
				$stmt->bindParam(':status',$status);
				$stmt->bindParam(':id',$article_id);
			
				$stmt->execute();

				$id = $article_id + 1024;
				if($status == 1){
					return '<span class="style-2"><i class="fa fa-globe"></i> เผยแพร่ #'.$id.'</span>';
				}
				else if($status == 0){
					return '<span class="style-3"><i class="fa fa-file-text-o"></i> ฉบับร่าง #'.$id.'</span>';
				}
			}
		catch(PDOException $e){
			return $msg['0'];
		}
	}



	public function listArticle($dbHandle,$event,$category,$type,$status,$start,$total){
		try{
			if($category == 0){
				$stmt = $dbHandle->prepare('SELECT ar_id,ar_title,ar_image,ar_description,ar_post_time,ar_status,ca_id,ca_title FROM bl_article,bl_category WHERE ar_category_id = ca_id AND ar_type = :type ORDER BY ar_post_time DESC LIMIT :start,:total');
				$stmt->bindParam(':type',$type);
				//$stmt->bindParam(':status',$status);

				$stmt->bindParam(':start',$start,PDO::PARAM_INT);
				$stmt->bindParam(':total',$total,PDO::PARAM_INT);

    			$stmt->execute();
			}

			else{
				$stmt = $dbHandle->prepare('SELECT ar_id,ar_title,ar_image,ar_description,ar_post_time,ar_status,ca_id,ca_title FROM bl_article,bl_category WHERE ar_category_id = ca_id AND ar_type = :type AND ar_category_id = :category ORDER BY ar_post_time DESC LIMIT :start,:total');
				$stmt->bindParam(':type',$type);
				//$stmt->bindParam(':status',$status);
				$stmt->bindParam(':category',$category);

				$stmt->bindParam(':start',$start,PDO::PARAM_INT);
				$stmt->bindParam(':total',$total,PDO::PARAM_INT);

    			$stmt->execute();
			}

			while($var = $stmt->fetch(PDO::FETCH_ASSOC)){
				if($event == "normal"){
					include'html/article-item.php';
				}
				else if($event == "ajax"){
					include'../html/article-item.php';
				}
			}
		}
		catch(PDOException $e){echo'ERROR:'.$e->getMessage();}
	}

	public function searchArticle($dbHandle,$event,$q){
		try{
			if($q != ""){
				$s = $q-1024;
				$stmt = $dbHandle->prepare('SELECT ar_id,ar_title,ar_image,ar_description,ar_post_time,ar_status,ca_id,ca_title FROM bl_article,bl_category WHERE (ar_id LIKE ? OR ar_title LIKE ? OR ar_description LIKE ? OR ar_keyword LIKE ?) AND (ar_category_id = ca_id) ORDER BY ar_title,ar_id,ar_description');
				
				$stmt->bindValue(1,"%$s%",PDO::PARAM_STR);
    			$stmt->bindValue(2,"%$q%",PDO::PARAM_STR);
    			$stmt->bindValue(3,"%$q%",PDO::PARAM_STR);
    			$stmt->bindValue(4,"%$q%",PDO::PARAM_STR);

    			$stmt->execute();
			}
			else{
				return 0;
			}

			while($var = $stmt->fetch(PDO::FETCH_ASSOC)){
				if($event == "normal"){
					include'html/article-item.php';
				}
				else if($event == "ajax"){
					include'../html/article-item.php';
				}
			}
		}
		catch(PDOException $e){echo'ERROR:'.$e->getMessage();}
	}

	// GET VIDEO DATA
	public function getArticleData($dbHandle,$id){
		$stmt = $dbHandle->prepare('SELECT * FROM bl_article WHERE ar_id = ?');
    	$stmt->execute(array($id));
		$var = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $var;
	}

	public function infoArticleData($dbHandle,$event){
		if($event == 'total'){
			$stmt = $dbHandle->prepare('SELECT COUNT(ar_id) FROM bl_article');
    		$stmt->execute(array($id));
    		$var = $stmt->fetch(PDO::FETCH_ASSOC);
    		return $var['COUNT(ar_id)'];
		}
	}
}
?>