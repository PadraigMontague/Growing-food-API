--
-- Database: `gardeningapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `fruit`
--

CREATE TABLE `fruit` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `plantingMonth` varchar(100) NOT NULL,
  `harvestMonth` varchar(100) NOT NULL,
  `soilType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fruit`
--

INSERT INTO `fruit` (`id`, `name`, `type`, `plantingMonth`, `harvestMonth`, `soilType`) VALUES
(1, 'Apple', 'Top Fruit', 'October - March', 'October', 'Fertile Soil'),
(2, 'Pear', 'Top Fruit', 'October - March', 'October', 'Fertile'),
(10, 'Orange', 'Citrus', 'April', 'September', 'Acidic'),
(11, 'Raspberry', 'Soft fruit', 'October', 'July - August', 'Nutrient Rich'),
(12, 'Gooseberry', 'Soft fruit', 'October', 'July - August', 'Nutrient Rich'),
(13, 'Blackcurrent', 'Soft fruit', 'October', 'July - August', 'Nutrient Rich'),
(14, 'Redcurrent', 'Soft fruit', 'October', 'July - August', 'Nutrient Rich'),
(15, 'Whitecurrent', 'Soft fruit', 'October', 'July - August', 'Nutrient Rich'),
(16, 'Blueberry', 'Soft fruit', 'October', 'July - August', 'Acidic soil'),
(17, 'Plum', 'Top fruit', 'October', 'August - October', 'Nutrient Rich'),
(18, 'Peaches', 'Top fruit', 'April', 'August', 'Nutrient Rich');

-- --------------------------------------------------------

--
-- Table structure for table `vegetables`
--

CREATE TABLE `vegetables` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `sowMonth` varchar(100) NOT NULL,
  `harvestMonth` varchar(100) NOT NULL,
  `minTemp` varchar(100) NOT NULL,
  `soilType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vegetables`
--

INSERT INTO `vegetables` (`id`, `name`, `type`, `sowMonth`, `harvestMonth`, `minTemp`, `soilType`) VALUES
(1, 'Carrot', 'Root Vegetable', 'April', 'August - September', '15 degrees', 'Sandy - Stone Free'),
(2, 'Tomato', 'Fruiting Vegetable', 'March - April', 'August - October', '15 degrees', 'Nutrient Rich'),
(3, 'Cabbage', 'Brassica', 'April', 'July - January', '5 degrees', 'Nutrient Rich'),
(4, 'Turnip', 'Brassica', 'April', 'July - December', '-2 degrees', 'Nutrient Rich'),
(5, 'Radish', 'Salad', 'March-July', 'May-October', '5 degrees', 'Nutrient Rich'),
(6, 'Onion', 'Allium', 'January', 'August', '10 degrees', 'Loam soil'),
(7, 'Leek', 'Allium', 'January', 'December', '10 degrees', 'Loam soil'),
(8, 'Garlic', 'Allium', 'January', 'December', '10 degrees', 'Nutrient Rich'),
(9, 'Lettuce', 'Salad', 'March - September', 'April - November', '10 degrees', 'Peat'),
(10, 'Parsnip', 'Root', 'March - September', 'November', '-5 degrees', 'Sandy - stone free'),
(11, 'Cauliflower', 'Brassica', 'March - May', 'September', '10 degrees', 'Nutrient Rich'),
(12, 'Brussels Sprouts', 'Brassica', 'March - May', 'December', '-5 degrees', 'Nutrient Rich'),
(13, 'Broccoli', 'Brassica', 'March - May', 'September - December', '-5 degrees', 'Nutrient Rich');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fruit`
--
ALTER TABLE `fruit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vegetables`
--
ALTER TABLE `vegetables`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fruit`
--
ALTER TABLE `fruit`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `vegetables`
--
ALTER TABLE `vegetables`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;