<?php
	session_start();
	
	function connexion()
	{
		try
		{
			$bd = new PDO('mysql:host=localhost;dbname=ait_scolarite','root','wilson');
			$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $bd;
		}
		catch(PDOException $ex)
		{
			return false;
		}
	}
	
	function checkCoefficient($promo, $mat, $niv)
	{
		$check = true;
		$promotion   = (int)$promo;
		$matiere     = (int)$mat;
		$niveau      = (int)$niv;
		
		if($promotion && $matiere && $niveau)
		{
			$bd = new PDO('mysql:host=localhost;dbname=ait_scolarite','root','wilson');
			$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$req = $bd->prepare("SELECT idDispenser FROM dispenser WHERE idPromotion = ? AND idMatiere = ? AND idNiveau = ?");
			
			$req->execute(array($promotion, $matiere, $niveau));
			
			$data = $req->fetchAll();
			$rep = count($data);
			
			if(!$rep)
				$check = false;
		}
		
		return $check;
	}
	
	function addCoefficient($promo, $mat, $niv, $coef)
	{
		$reussite    = 0;
		$promotion   = (int)$promo;
		$matiere     = (int)$mat;
		$niveau      = (int)$niv;
		$coefficient = (int)$coef;
		
		if($promotion && $matiere && $niveau && $coefficient > 0)
		{
			$bd = new PDO('mysql:host=localhost;dbname=ait_scolarite','root','wilson');
			$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$req = $bd->prepare("INSERT INTO dispenser(idPromotion, idMatiere, idNiveau, coefMatiere) VALUES(? ,?, ?, ?)");
			
			if($req->execute(array($promotion, $matiere, $niveau, $coefficient)))
				$reussite = 1;
		}
		
		return $reussite;
	}
	
	$variable = $_POST['d'];
	$promo    = (int)$_POST['promo'];
	$niveau   = (int)$_POST['niveau'];
	
	$tab = explode(',',$variable); //Les cases cochées
	$nb = 0;
	foreach($tab as $ligne)
	{
		$matCoef = explode(':',$ligne); //matière:coefficient
		if(!checkCoefficient($promo, $matCoef[0], $niveau))
			$nb += addCoefficient($promo, $matCoef[0], $niveau, $matCoef[1]);
	}
	
	exit($nb . " R&eacute;ussite(s)");
