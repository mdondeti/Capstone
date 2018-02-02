package Tests;


import static org.testng.Assert.assertEquals;
import static org.testng.Assert.assertTrue;
import static org.testng.Assert.fail;

import java.io.FileInputStream;
import java.sql.Driver;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.concurrent.TimeUnit;

import org.testng.asserts.*;
import org.openqa.selenium.support.ui.WebDriverWait;

import org.apache.poi.ss.usermodel.CellType;
import org.apache.poi.ss.usermodel.DataFormatter;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.junit.BeforeClass;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;
import org.testng.annotations.*;
import Repos.RegisterPage;

import org.openqa.selenium.support.ui.ExpectedCondition ;
import org.openqa.selenium.support.ui.ExpectedConditions;

public class addStudentTest extends BaseTest {
 
	static XSSFWorkbook workBook; 
	static XSSFSheet sheet;
	static XSSFRow row;
	static int i=0;
	static int j=0;
	static Object[][] DataCellValues;
	WebDriver driver = new FirefoxDriver();
	
public addStudentTest()
{
	super();
}
  
public static Object[][] dataInputFromExcel() throws Exception
{
	FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
	workBook = new XSSFWorkbook(fs);
	sheet = workBook.getSheet("Login");

	int k=sheet.getLastRowNum();//get the number of rows

	int l=sheet.getRow(0).getLastCellNum();//get the number of columns in first row

	//define a string type two dimensional array
	DataCellValues = new Object[k+1][l];
	for(i=0;i<=k;i++)
	{
		row= sheet.getRow(i);
		for(j=0;j<l-1;j++)
		{
			XSSFCell cell= row.getCell(j);	
			if(row.getCell(j)==null)
			{
				DataCellValues[i][j]="";
			}
			else
			{
				DataCellValues[i][j]= new DataFormatter().formatCellValue(row.getCell(j));
			}


		}
	}
	return DataCellValues;

}
  
  
  
  
  
}
