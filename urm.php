<?php
$registers=array("R1"=>9,"R2"=>4,"R3"=>2,"R4"=>0,"R5"=>0);
//var_dump($registers);
$commands=array("j(R1,R2,5)","s(R2)","s(R3)","j(R1,R2,5)","j(R1,R1,1)","t(R3,R1)");
$inst = new urmsemu($commands,$registers);
$inst->execute();
class urmsemu
{
	private $commands= array();
	private $registers= array();
	static 	$instruction_pointer=0;
	static  $MAX=100;
	function __construct($commands,$registers)
	{
		$this->commands=$commands;
		$this->registers=$registers;
	//	show($this->registers);
	}
	
	function execute()
	{
		while(self::$instruction_pointer<count($this->commands)){
			$command=$this->commands[self::$instruction_pointer];
			echo "current instruction number = ".self::$instruction_pointer." ---- ";
			$op=$command[0];
			$arg=explode(',',(normalize($command)));
			printf("operation= %s ---- args= %s,%s,%s <br />",$op,$arg[0],$arg[1],$arg[2]);
			switch($op){
			case 's':
				$this->registers[$arg[0]]++;
				break;
			case 'z':
				$this->registers[$arg[0]]=0;
				break;
			case 't':
				$this->registers[$arg[1]]=$this->registers[$arg[0]];
				break;
			case 'j':
				if($this->registers[$arg[0]]==$this->registers[$arg[1]])
					self::$instruction_pointer=$arg[2]-1;
				break;
			default:
				echo $op." is unknown operation";self::$instruction_pointer=count($this->commands);
			}
		show($this->registers);
		self::$instruction_pointer++;
		}
	}
}

	function show ($registers)
	{	
		foreach($registers as $k=>$v)
			echo $k."=".$v."  "	;
		echo "<hr  />";
	}
	function normalize ($command)
	{
		preg_match('#\((.*?)\)#', $command, $result);
	//	$result=explode(',',$result[1]);
	//	print_r($result[1]);
		return $result[1];
	}
?>
