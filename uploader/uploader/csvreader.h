#pragma once

#include <string>
#include <iostream>
#include <list>
#include "result.h"
#include <fstream>
#include <sstream>

int st(std::string &s) {
	std::stringstream S;
	S << s;
	int h, m, ss;
	std::string H, M, SS;
	getline(S, H, ':');
	getline(S, M, ':');
	getline(S, SS, ',');
	h = std::stoi(H);
	m = std::stoi(M);
	ss = std::stoi(SS);
	return (h * 60 * 60 + m * 60 + ss);
}

void read(std::string name, std::list<Result> & l) {
	try {
		std::ifstream file(name);
		file.ignore(std::numeric_limits<std::streamsize>::max(),'\n');
		int f= 2;
		for (;;) {
			//std::cout << std::endl << f++;
			if (file.eof() || file.bad() ||file.peek()==EOF)
				break;
			
			for (int i = 0; i < 5; i++) 
				file.ignore(std::numeric_limits<std::streamsize>::max(),';');

			Result r;
			getline(file, r.lastname, ';');
			getline(file, r.firstname, ';');

			for (int i = 0; i < 4; i++)
				file.ignore(std::numeric_limits<std::streamsize>::max(), ';');

			std::string time;
			getline(file, time, ';'); //start
			r.start = st(time);
			getline(file, time, ';'); //finish
			r.finish = time!=""?st(time):0;
			getline(file, time, ';'); //time
			r.time = time != "" ? st(time) : 0;

			getline(file, time, ';'); //classifier
			r.status = (char)stoi(time);

			for (int i = 0; i < 4; i++)
				file.ignore(std::numeric_limits<std::streamsize>::max(), ';');

			std::string cl1, cl2;
			getline(file, cl1, ';');
			getline(file, cl2, ';');
			r.club = (cl1 != "")? cl1 +" "+ cl2:cl2;

			for (int i = 0; i < 4; i++)
				file.ignore(std::numeric_limits<std::streamsize>::max(), ';');

			getline(file, r.category, ';');

			for (int i = 0; i < 34; i++)
				file.ignore(std::numeric_limits<std::streamsize>::max(), ';');


			for (int j = 0; file.peek() != '\n'; j++) {
				getline(file, time, ';');
				r.checknr[j] = stoi(time);
				getline(file, time, ';');
				// -----
				if (time == "-----")
					r.check[j] = 0;
				else
					r.check[j] = st(time);
			}
			file.get();
			l.push_back(r);
		}
		file.close();
	}
	catch (std::exception &e) {
		std::cout << e.what() << std::endl;
	}
	std::cout << "read complete" << std::endl;
}
