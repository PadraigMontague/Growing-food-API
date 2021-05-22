--
-- Database: `reports`
--

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(5) NOT NULL,
  `username` varchar(255) NOT NULL,
  `dateReq` varchar(250) NOT NULL,
  `timeReq` varchar(255) NOT NULL,
  `request_type` varchar(250) NOT NULL,
  `request_format` varchar(250) NOT NULL,
  `status_code` varchar(250) NOT NULL,
  `request_url` varchar(250) NOT NULL,
  `clientIP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=565;
COMMIT;
