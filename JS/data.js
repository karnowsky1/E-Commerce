//For the project:
var data=new Object();// writes this so we can make new bojects jsut by writing data
data['init'] = [null, "Select Time Period", "90's", "2000's", "2010's"];

data["90's"] = ['TV.jpg', 'Which studio', "90's Nickelodeon", "90's Disney", "90's CartoonNetwork"];
data["2000's"] = ['TV.jpg', 'Which studio', "2000's Nickelodeon", "2000's Disney", "2000's CartoonNetwork"];
data["2010's"] = ['TV.jpg', 'Which studio', "2010's Nickelodeon", "2010's Disney", "2010's CartoonNetwork"];

data["90's Nickelodeon"] = ['Cartoon.jpg', "What's on TV?", 'Rugrats', 'The Ren n Stimpy Show', 'Hey Arnold!', 'CatDog'];
data["2000's Nickelodeon"] = ['Cartoon.jpg', "What's on TV?", 'Invader Zim', 'Rocket Power', 'My Life as a Teenage Robot', 'El Tigre!', 'SpongeBob SquarePants'];
data["2010's Nickelodeon"] = ['Cartoon.jpg', "What's on TV?", 'The Legend of Korra', 'The Penguins of Madagascar', 'Domo TV'];

data["90's Disney"] = ['Cartoon.jpg', "What's on TV?", 'Gargoyles', 'Aladdin', 'Recess', 'Hercules', 'Quack Pack'];
data["2000's Disney"] = ['Cartoon.jpg', "What's on TV?", 'The Proud Family', 'Kim Possible', 'Lilo n Stitch The Series', 'American Dragon Jake Long'];
data["2010's Disney"] = ['Cartoon.jpg', "What's on TV?", "Kick Buttowski!", 'Gravity Falls', 'Phineas and Ferb'];

data["90's CartoonNetwork"] = ['Cartoon.jpg', "What's on TV?", 'Ed Edd n Eddy', "Dexters Laboratory", "Johnny Bravo", "Courage The Cowardly Dog"];
data["2000's CartoonNetwork"] = ['Cartoon.jpg', "What's on TV?", 'The Grim Adventures of Billy n Mandy', 'Mucha Lucha!', 'Codename Kids Next Door', 'Code Lyoko', 'Chowder', 'Robotboy', 'Ben 10', "Robot Jones"];
data["2010's CartoonNetwork"] = ['Cartoon.jpg', "What's on TV?", 'Steven Universe', 'Adventure Time', 'The Amazing World of Gumball', 'Young Justice'];

var currentState = "off";
