SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `assigned_penalties` (
  `id` int(11) NOT NULL,
  `penalty` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `assigned_by` varchar(255) NOT NULL,
  `assigned_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `penalties` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `perms` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `passwordhash` text NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `assigned_penalties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penalty_assigned` (`penalty`),
  ADD KEY `user_assigned` (`user`),
  ADD KEY `user_assigned_by` (`assigned_by`);

ALTER TABLE `penalties`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `role_user` (`role`);


ALTER TABLE `assigned_penalties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `penalties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `assigned_penalties`
  ADD CONSTRAINT `penalty_assigned` FOREIGN KEY (`penalty`) REFERENCES `penalties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_assigned` FOREIGN KEY (`user`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_assigned_by` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`username`);

ALTER TABLE `users`
  ADD CONSTRAINT `role_user` FOREIGN KEY (`role`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
