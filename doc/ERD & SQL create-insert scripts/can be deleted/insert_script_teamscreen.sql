-- ---------------------------------------
-- insert script for teamscreen application database
-- ------------------------------------------

insert into `teamscreen`.`team` (`label`) values ('team 1');
insert into `teamscreen`.`team` (`label`) values ('team 2');
insert into `teamscreen`.`team` (`label`) values ('team 3');


INSERT INTO `teamscreen`.`member` 
(`name`, `username`, `destination`, `drink_preference`, `working_days`, `team_id`) VALUES 

('Petri', 'petri', 'Dam, 1012KB Amsterdam', 'tea', 'monday,tuesday,wednesday,thursday', '1'),
('Agung', 'agung.udijana', 'Spijkweg 30, 8256 RJ Biddinghuizen', 'coffee', 'monday,tuesday,wednesday,thursday', '1'),
('Carina', 'Carina', 'Berlijnplein 100, 3541 CM Utrecht', 'coffee', 'monday,tuesday,wednesday,thursday', '1'),
('Emiel', 'emiel.nijhuis', 'Boulevard ZeeZijde 7, 2225 AB Katwijk aan Zee', 'coffee', 'monday,tuesday,wednesday,thursday', '1'),
('Paul', 'paul.sinterniklaas', 'Plein 2, 2511 CR Den Haag', 'coffee', 'monday,tuesday,wednesday,thursday', '1'),
('Dominic', 'dominic', 'Domplein 21, 3512 JC Utrecht', 'coffee', 'monday,tuesday,wednesday,thursday', '1'),
('Vincent', 'vincent.huijts%40hva.nl', 'Veemarktstraat 44, 5038 CV Tilburg', 'tea', 'monday,tuesday,wednesday,thursday', '1');




insert into `teamscreen`.`time_off` (`start_time`, `end_time`, `member_id`) values ('2018-03-19 12:00:00', '2018-03-21 12:00:00', 1);
insert into `teamscreen`.`time_off` (`start_time`, `end_time`, `member_id`) values ('2018-03-19 12:00:00', '2018-03-21 12:00:00', 2);
