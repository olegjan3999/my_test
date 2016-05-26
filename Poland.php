<?php

    /**
     * Class Poland
     */
    class Poland {

        /**
         * Stack array
         *
         * @var \SplStack $stack
         */
        private $stack;

        /**
         * Available operands
         *
         * @var $operands array
         */
        private $operands = ['+', '-', '*', '/'];

        /**
         * Input param
         *
         * @var array $io
         */
        private $io = [];

        /**
         * Poland constructor.
         */
        public function __construct() {

            // init stack
            $this->stack = new \SplStack();
        }

        /**
         * Set input param
         *
         * @param string $io
         * @return Poland
         */
        public function setIo($io) {
            $this->io = explode(' ', $io);

            return $this;
        }

        /**
         * Set operands
         *
         * @param array $operands
         * @return Poland
         */
        private function setOperands(array $operands) {
            $this->operands = $operands;

            return $this;
        }

        /**
         * Get operands
         *
         * @param array $operands
         * @return array
         */
        public function getOperands() {
           return $this->operands;
        }


        /**
         * Calculate expressin
         * @return string
         * @throws \Exception
         */
        public function calculate() {

            if(empty($this->io)) {
                throw new \Exception("You must assign a string to instance object param");
            }

            foreach($this->io as $item) {

                if(in_array($item, $this->getOperands())) {

                    if($this->stack->count() < 2 ) {
                        throw new \Exception("invalid count of arguments");
                    }

                    $farg = $this->stack->pop();
                    $larg = $this->stack->pop();
                    $expression = $farg.$item.$larg;
                    // remove any non-numbers chars; exception for math operators
                    $expression = preg_replace ('[^0-9\+-\*\/\(\) ]', '', $expression);

                    $res = eval('return '.$expression.';');
                    $this->stack->push($res);
                }
                else {
                    if(!is_numeric($item)) {
                        throw new \Exception("invalid value ".$item);
                    }
                    // push value to stack
                    $this->stack->push($item);
                }
            }

            return $this->stack->pop();
        }
    }

    $calc = new Poland();


    echo $calc->setIo('15 10 1 + *')->calculate()."<br>";
    echo $calc->setIo('5 5 + 5 *')->calculate()."<br>";